<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ClassLevel;
use App\Models\ExamResult;

class AdminExamEntry extends Component
{
    public $class_level_id = '';
    public $subject_id = '';
    public $students = [];
    public $classes = [];
    public $subjects = [];
    public $allSubjectsEntered = false;

    public function mount()
    {
        $this->classes = ClassLevel::all();
        $this->subjects = Subject::all();
    }

    public function updatedClassLevelId()
    {
        $this->subject_id = '';
        $this->students = [];
        $this->allSubjectsEntered = false;
        if ($this->class_level_id) {
            $this->loadStudents();
        }
    }

    public function updatedSubjectId()
    {
        $this->loadStudents();
    }

    public function loadStudents()
    {
        if (!$this->class_level_id || !$this->subject_id) return;

        $students = Student::where('class_level_id', $this->class_level_id)->get();

        $this->students = $students->map(function ($student) {
            $record = ExamResult::where('student_id', $student->id)
                                ->where('subject_id', $this->subject_id)
                                ->first();
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
        if (!$this->class_level_id) return;
        $students = Student::where('class_level_id', $this->class_level_id)->get();
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

    public function saveGrades()
    {
        if (!$this->subject_id || !$this->class_level_id) {
            session()->flash('error', 'Please select a class and subject first.');
            return;
        }

        foreach ($this->students as $studentData) {
            $totalScore = (int)($studentData['score'] ?: 0);

            ExamResult::updateOrCreate(
                ['student_id' => $studentData['id'], 'subject_id' => $this->subject_id],
                [
                    'exam_type' => 'Final Exam', // THIS FIXES THE ERROR
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
        if (!$this->subject_id || !$this->class_level_id) return;

        $students = Student::where('class_level_id', $this->class_level_id)->get();
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
        if (!$this->class_level_id) return;

        $students = Student::where('class_level_id', $this->class_level_id)->get();
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
        return view('livewire.admin-exam-entry');
    }
}