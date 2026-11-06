<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\AcademicSession;
use App\Models\Section;

class DashboardStats extends Component
{
    public $totalStudents = 0;
    public $totalClasses = 0;
    public $totalSessions = 0;
    public $totalSections = 0;

    public function mount()
    {
        $this->totalStudents = Student::count();
        $this->totalClasses = ClassLevel::count();
        $this->totalSessions = AcademicSession::count();
        $this->totalSections = Section::count();
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}