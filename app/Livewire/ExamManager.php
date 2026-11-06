<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\Subject;

class ExamManager extends Component
{
    public $class_level_id = '';
    public $subject_id = '';
    public $exam_type = 'Midterm';
    
    public $students = [];
    public $classLevels = [];
    public $subjects = [];
    public $marks = [];

    public function mount()
    {
        $this->classLevels = ClassLevel::all();
        $this->subjects = Subject::all();
    }

    public function updatedClassLevelId() { $this->loadStudents(); }
    public function updatedSubjectId() { $this->loadStudents(); }
    public function updatedExamType() { $this->loadStudents(); }

    public function loadStudents()
    {
        if ($this->class_level_id && $this->subject_id) {
            $this->students = Student::where('class_level_id', $this->class_level_id)->get();
            
            // Load existing marks
            $studentIds = $this->students->pluck('id');
            $existing = ExamResult::where('subject_id', $this->subject_id)
                                  ->where('exam_type', $this->exam_type)
                                  ->whereIn('student_id', $studentIds)->get();
            $this->marks = $existing->pluck('marks', 'student_id')->toArray();
        } else {
            $this->students = [];
        }
    }

    public function save()
    {
        $this->validate([
            'class_level_id' => 'required',
            'subject_id' => 'required',
        ]);

        foreach ($this->marks as $studentId => $mark) {
            if ($mark !== null && $mark !== '') {
                ExamResult::updateOrCreate(
                    ['student_id' => $studentId, 'subject_id' => $this->subject_id, 'exam_type' => $this->exam_type],
                    ['marks' => $mark]
                );
            }
        }

        session()->flash('message', 'Exam marks saved successfully!');
    }

    public function render() { return view('livewire.exam-manager'); }
}