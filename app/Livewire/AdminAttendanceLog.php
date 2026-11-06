<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\ClassLevel;

class AdminAttendanceLog extends Component
{
    public $selectedClassId = '';
    public $classes = [];
    public $attendanceRecords = [];

    public function mount()
    {
        $this->classes = ClassLevel::all();
        $this->loadAttendance();
    }

    public function updatedSelectedClassId()
    {
        $this->loadAttendance();
    }

    public function loadAttendance()
    {
        if ($this->selectedClassId) {
            // Only get attendance for students in the selected class
            $this->attendanceRecords = Attendance::whereHas('student', function ($query) {
                $query->where('class_level_id', $this->selectedClassId);
            })
            ->with(['student.classLevel'])
            ->latest('date')
            ->get();
        } else {
            $this->attendanceRecords = collect();
        }
    }

    public function render()
    {
        return view('livewire.admin-attendance-log');
    }
}