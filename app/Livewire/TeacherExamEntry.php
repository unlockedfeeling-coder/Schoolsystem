<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamResult;

class TeacherExamEntry extends Component
{
    public $subject_id = '';
    public $students = [];
    public $subjects = [];
    public $class_name = 'Unknown Class';
    public $allSubjectsEntered = false;

    public function mount()
    {
        $this->subjects = Subject::all();
        $this->loadClassData();
    }

    public function loadClassData()
    {
        // FIX: Use 'user_id' to find the teacher profile
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        if (!$teacher || !$teacher->class_level_id) {
            $this->class_name = 'No Class Assigned';
            return;
        }

        $this->class_name = $teacher->classLevel->name ?? 'Unknown Class';
        
        if (!$this->subject_id && $teacher->subject_id) {
            $this->subject_id = $teacher->subject_id;
        }

        $students = Student::where('class_level_id', $teacher->class_level_id)->get();

        $this->students = $students->map(function ($student) {
            $record = null;
            if ($this->subject_id) {
                $record = ExamResult::where('student_id', $student->id)
                                    ->where('subject_id', $this->subject_id)
                                    ->first();
            }
            return [
                'id' => $student->id,
                'name' => $student->first_name . ' ' . $student->last_name,
                'score' => $record ? $record->total_score : ''
            ];
        })->toArray();

        $this->checkAllSubjectsEntered();
    }

    public function checkAllSubjectsEntered()
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        if (!$teacher || !$teacher->class_level_id) return;

        $students = Student::where('class_level_id', $teacher->class_level_id)->get();
        $allSubjects = Subject::all();
        
        $this->allSubjectsEntered = true;
        
        foreach ($students as $student) {
            foreach ($allSubjects as $subject) {
                $exists = ExamResult::where('student_id', $student->id)
                                    ->where('subject_id', $subject->id)
                                    ->where('total_score', '>', 0)
                                    ->exists();
                if (!$exists) {
                    $this->allSubjectsEntered = false;
                    return;
                }
            }
        }
    }

    public function updatedSubjectId()
    {
        $this->loadClassData();
    }

    public function saveGrades()
    {
        if (!$this->subject_id) {
            session()->flash('error', 'Please select a subject first.');
            return;
        }

        foreach ($this->students as $studentData) {
            $totalScore = (int)($studentData['score'] ?: 0);

            ExamResult::updateOrCreate(
                ['student_id' => $studentData['id'], 'subject_id' => $this->subject_id],
                [
                    'exam_type' => 'Final Exam',
                    'class_score' => 0,
                    'exam_score' => $totalScore,
                    'total_score' => $totalScore,
                    'marks' => $totalScore 
                ]
            );
        }

        $this->calculateSubjectPositions();

        session()->flash('message', 'Grades saved and subject positions calculated!');
        $this->checkAllSubjectsEntered();
    }

    public function calculateSubjectPositions()
    {
        if (!$this->subject_id) return;

        $teacher = Teacher::where('user_id', auth()->id())->first();
        if (!$teacher || !$teacher->class_level_id) return;

        $students = Student::where('class_level_id', $teacher->class_level_id)->get();
        $studentScores = [];

        foreach ($students as $student) {
            $record = ExamResult::where('student_id', $student->id)
                                ->where('subject_id', $this->subject_id)
                                ->first();
            $studentScores[$student->id] = $record ? $record->total_score : 0;
        }

        arsort($studentScores);

        $position = 1;
        foreach ($studentScores as $studentId => $score) {
            ExamResult::where('student_id', $studentId)
                      ->where('subject_id', $this->subject_id)
                      ->update(['subject_position' => $position]);
            $position++;
        }
    }

    public function calculateOverallPositions()
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        if (!$teacher || !$teacher->class_level_id) return;

        $students = Student::where('class_level_id', $teacher->class_level_id)->get();
        $studentTotals = [];

        foreach ($students as $student) {
            $totalAggregate = ExamResult::where('student_id', $student->id)->sum('total_score');
            $studentTotals[$student->id] = $totalAggregate;
        }

        arsort($studentTotals);

        $position = 1;
        foreach ($studentTotals as $studentId => $score) {
            ExamResult::where('student_id', $studentId)->update(['position' => $position]);
            $position++;
        }

        session()->flash('message', 'Overall class positions calculated successfully!');
    }

    public function render()
    {
        return view('livewire.teacher-exam-entry');
    }
}