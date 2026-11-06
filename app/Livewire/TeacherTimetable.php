<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Timetable;
use App\Models\Teacher;
use Carbon\Carbon;

class TeacherTimetable extends Component
{
    public $currentTime;
    public $currentDay;
    public $todayLessons = [];
    public $weekLessons = [];
    public $upcomingLesson = null;
    public $currentLesson = null;
    public $nextLessonReminder = '';

    public function mount()
    {
        $this->loadTimetable();
    }

    public function loadTimetable()
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        if (!$teacher) {
            $this->todayLessons = collect();
            $this->weekLessons = collect();
            return;
        }

        $now = Carbon::now();
        $this->currentTime = $now->format('H:i:s');
        $this->currentDay = $now->format('l'); // e.g. "Monday"

        // Get all lessons for this teacher
        $allLessons = Timetable::where('teacher_id', $teacher->id)
            ->with(['subject', 'classLevel'])
            ->orderByRaw("FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday')")
            ->orderBy('start_time')
            ->get();

        $this->weekLessons = $allLessons;

        // Filter today's lessons
        $this->todayLessons = $allLessons->filter(function ($lesson) {
            return $lesson->day === $this->currentDay;
        })->values();

        // Find current and upcoming lessons
        $this->findCurrentAndUpcoming($allLessons, $now);
    }

    protected function findCurrentAndUpcoming($allLessons, $now)
    {
        $this->currentLesson = null;
        $this->upcomingLesson = null;
        $this->nextLessonReminder = '';

        // Only check on weekdays
        if (!in_array($this->currentDay, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])) {
            return;
        }

        $todayLessons = $allLessons->filter(fn($l) => $l->day === $this->currentDay)->values();

        foreach ($todayLessons as $lesson) {
            $start = Carbon::parse($lesson->start_time);
            $end = Carbon::parse($lesson->end_time);

            // Is this lesson happening RIGHT NOW?
            if ($now->between($start, $end)) {
                $this->currentLesson = $lesson;
                $minutesLeft = $now->diffInMinutes($end);
                $this->nextLessonReminder = "You are currently teaching {$lesson->subject->name} to {$lesson->classLevel->name}. {$minutesLeft} minutes remaining.";
                return;
            }

            // Is this lesson coming up in the next 30 minutes?
            if ($now->between($start->copy()->subMinutes(30), $start)) {
                $minutesUntil = $now->diffInMinutes($start);
                $this->upcomingLesson = $lesson;
                $this->nextLessonReminder = " REMINDER: Your next lesson starts in {$minutesUntil} minute(s) - {$lesson->subject->name} with {$lesson->classLevel->name} in {$lesson->room}.";
                return;
            }

            // Is this lesson in the future today?
            if ($start->isFuture() && $start->gt($now)) {
                if (!$this->upcomingLesson) {
                    $this->upcomingLesson = $lesson;
                    $hoursUntil = $now->diffInHours($start);
                    $this->nextLessonReminder = "Next lesson today: {$lesson->subject->name} with {$lesson->classLevel->name} at {$start->format('g:i A')} (in {$hoursUntil} hour(s)).";
                }
                break;
            }
        }

        // If no lessons today, find the next day's first lesson
        if (!$this->upcomingLesson && !$this->currentLesson) {
            $futureLessons = $allLessons->filter(function ($lesson) use ($now) {
                $dayOrder = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5];
                $currentDayNum = $dayOrder[$this->currentDay] ?? 0;
                $lessonDayNum = $dayOrder[$lesson->day] ?? 0;
                return $lessonDayNum > $currentDayNum;
            });

            if ($futureLessons->count() > 0) {
                $next = $futureLessons->first();
                $this->nextLessonReminder = "No more lessons today. Next lesson: {$next->subject->name} with {$next->classLevel->name} on {$next->day} at " . Carbon::parse($next->start_time)->format('g:i A') . ".";
            } else {
                $this->nextLessonReminder = "No upcoming lessons this week. Enjoy your break!";
            }
        }
    }

    public function render()
    {
        return view('livewire.teacher-timetable');
    }
}