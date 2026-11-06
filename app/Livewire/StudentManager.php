<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\Section;
use App\Models\AcademicSession;
use App\Models\User; // NEW: To fetch parents

class StudentManager extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $admission_number = '';
    public $date_of_birth = '';
    public $gender = '';
    public $class_level_id = '';
    public $section_id = '';
    public $enrollment_year = '';
    public $parent_id = ''; // NEW: To link the parent
    
    public $activeSessionName = 'No Active Session';
    public $search = ''; 
    
    public $students = [];
    public $classLevels = [];
    public $parents = []; // NEW: List of parents
    public $available_sections = [];

    public function mount() { 
        $this->loadData(); 
        $this->parents = User::where('role', 'parent')->get(); // NEW: Fetch all parents
        $session = AcademicSession::where('is_active', true)->first();
        if ($session) {
            $this->activeSessionName = $session->name;
        }
    }

    public function updatedClassLevelId($value) {
        $this->section_id = '';
        if ($value) {
            $this->available_sections = Section::where('class_level_id', $value)->get();
        } else {
            $this->available_sections = [];
        }
    }

    public function loadData()
    {
        $this->classLevels = ClassLevel::all();
        $this->available_sections = [];
        
        $query = Student::with(['classLevel', 'section', 'parent']); // NEW: Load parent data
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name', 'like', '%'.$this->search.'%')
                  ->orWhere('admission_number', 'like', '%'.$this->search.'%');
            });
        }
        
        $this->students = $query->latest()->get();
    }

    public function updatedSearch() {
        $this->loadData();
    }

    public function save()
    {
        $activeSession = AcademicSession::where('is_active', true)->first();
        
        if (!$activeSession) {
            session()->flash('error_message', 'Cannot register student! Please go to "Academic Sessions" and set a session as Active first.');
            return;
        }

        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'admission_number' => 'required|unique:students,admission_number',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'class_level_id' => 'required',
            'section_id' => 'required',
            'enrollment_year' => 'required|integer|min:2000|max:2100',
            'parent_id' => 'nullable', // Parent is optional during registration, can be added later
        ]);

        Student::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'admission_number' => $this->admission_number,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'class_level_id' => $this->class_level_id,
            'section_id' => $this->section_id,
            'academic_session_id' => $activeSession->id,
            'enrollment_year' => $this->enrollment_year,
            'parent_id' => $this->parent_id ?: null, // NEW: Save the link
        ]);

        session()->flash('message', 'Student registered successfully for ' . $this->activeSessionName . '!');
        $this->first_name = ''; $this->last_name = ''; $this->admission_number = '';
        $this->date_of_birth = ''; $this->gender = '';
        $this->class_level_id = ''; $this->section_id = ''; $this->enrollment_year = ''; $this->parent_id = '';
        $this->available_sections = [];
        $this->loadData();
    }

    public function render() { return view('livewire.student-manager'); }
}