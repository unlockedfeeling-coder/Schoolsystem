<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Timetable;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassLevel;

class AdminTimetableManager extends Component
{
    // Form fields
    public $day = '';
    public $start_time = '';
    public $end_time = '';
    public $subject_id = '';
    public $class_level_id = '';
    public $teacher_id = '';
    public $room = '';

    // Filters
    public $filterClassId = '';
    public $filterDay = '';

    // Data
    public $teachers = [];
    public $subjects = [];
    public $classes = [];
    public $entries = [];
    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    public function mount()
    {
        $this->teachers = Teacher::with(['subject', 'classLevel'])->get();
        $this->subjects = Subject::all();
        $this->classes = ClassLevel::all();
        $this->loadEntries();
    }

    public function loadEntries()
    {
        $query = Timetable::with(['teacher', 'subject', 'classLevel']);

        if ($this->filterClassId) {
            $query->where('class_level_id', $this->filterClassId);
        }
        if ($this->filterDay) {
            $query->where('day', $this->filterDay);
        }

        $this->entries = $query->orderByRaw("FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday')")
                               ->orderBy('start_time')
                               ->get();
    }

    public function updatedFilterClassId() { $this->loadEntries(); }
    public function updatedFilterDay() { $this->loadEntries(); }

    public function save()
    {
        $this->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'subject_id' => 'required',
            'class_level_id' => 'required',
            'teacher_id' => 'required',
        ]);

        Timetable::create([
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'subject_id' => $this->subject_id,
            'class_level_id' => $this->class_level_id,
            'teacher_id' => $this->teacher_id,
            'room' => $this->room ?: null,
        ]);

        $this->day = ''; $this->start_time = ''; $this->end_time = '';
        $this->subject_id = ''; $this->class_level_id = ''; $this->teacher_id = ''; $this->room = '';

        session()->flash('message', 'Timetable entry added successfully!');
        $this->loadEntries();
    }

    public function delete($id)
    {
        Timetable::find($id)->delete();
        session()->flash('message', 'Entry deleted.');
        $this->loadEntries();
    }

    public function render()
    {
        return view('livewire.admin-timetable-manager');
    }
}