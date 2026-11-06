<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\Fee;

class StudentProfile extends Component
{
    public $studentId;
    public $student;
    public $attendanceStats = [];
    public $exams = [];
    public $fees = [];
    public $totalFees = 0;
    public $paidFees = 0;

    public function mount($id)
    {
        $this->studentId = $id;
        $this->student = Student::with(['classLevel', 'section'])->findOrFail($id);
        
        // Get Attendance Stats
        $this->attendanceStats = Attendance::where('student_id', $id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get Recent Exams
        $this->exams = ExamResult::where('student_id', $id)
            ->with('subject')
            ->latest()
            ->take(5)
            ->get();

        // Get Fees
        $this->fees = Fee::where('student_id', $id)->latest()->get();
        $this->totalFees = Fee::where('student_id', $id)->sum('amount');
        $this->paidFees = Fee::where('student_id', $id)->where('status', 'Paid')->sum('amount');
    }

    public function render()
    {
        return view('livewire.student-profile');
    }
}