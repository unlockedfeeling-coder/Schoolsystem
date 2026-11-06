<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Attendance;

class TeacherAttendanceMark extends Component
{
    public $date;
    public $students = [];
    public $class_name = 'Unknown Class';

    public function mount()
    {
        $this->date = date('Y-m-d');
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
        $students = Student::where('class_level_id', $teacher->class_level_id)->get();

        $this->students = $students->map(function ($student) {
            $record = Attendance::where('student_id', $student->id)
                                ->where('date', $this->date)
                                ->first();
            return [
                'id' => $student->id,
                'name' => $student->first_name . ' ' . $student->last_name,
                'status' => $record ? $record->status : 'Present'
            ];
        })->toArray();
    }

    public function updatedDate()
    {
        $this->loadClassData();
    }

    public function saveAttendance()
    {
        foreach ($this->students as $studentData) {
            Attendance::updateOrCreate(
                ['student_id' => $studentData['id'], 'date' => $this->date],
                ['status' => $studentData['status']]
            );
        }
        session()->flash('message', 'Attendance saved successfully for ' . $this->date . '!');
    }

    public function render()
    {
        return view('livewire.teacher-attendance-mark');
    }
}