<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\Section;

class AttendanceManager extends Component
{
    public $class_level_id = '';
    public $section_id = '';
    public $date = '';
    
    public $students = [];
    public $classLevels = [];
    public $sections = [];
    public $attendance = [];

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->classLevels = ClassLevel::all();
        $this->sections = Section::all();
    }

    public function updatedClassLevelId() { $this->loadStudents(); }
    public function updatedSectionId() { $this->loadStudents(); }
    public function updatedDate() { $this->loadStudents(); }

    public function loadStudents()
    {
        if ($this->class_level_id && $this->section_id) {
            $this->students = Student::where('class_level_id', $this->class_level_id)
                                     ->where('section_id', $this->section_id)
                                     ->get();
            
            // Load existing attendance for this date
            $studentIds = $this->students->pluck('id');
            $existing = Attendance::where('date', $this->date)->whereIn('student_id', $studentIds)->get();
            $this->attendance = $existing->pluck('status', 'student_id')->toArray();
        } else {
            $this->students = [];
        }
    }

    public function save()
    {
        $this->validate([
            'class_level_id' => 'required',
            'section_id' => 'required',
            'date' => 'required|date',
        ]);

        foreach ($this->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $this->date],
                ['status' => $status]
            );
        }

        session()->flash('message', 'Attendance saved successfully!');
    }

    public function render() { return view('livewire.attendance-manager'); }
}