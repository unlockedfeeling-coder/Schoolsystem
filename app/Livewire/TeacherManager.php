<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use App\Models\ClassLevel;
use Illuminate\Support\Facades\Hash;

class TeacherManager extends Component
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone = '';
    public $subject_id = '';
    public $class_level_id = '';
    
    public $teachers = [];
    public $subjects = [];
    public $classes = [];
    public $search = '';

    public function mount()
    {
        $this->subjects = Subject::all();
        $this->classes = ClassLevel::all();
        $this->loadTeachers();
    }

    public function loadTeachers()
    {
        $query = Teacher::with(['subject', 'classLevel', 'user']);
        
        if ($this->search) {
            $query->where('first_name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name', 'like', '%'.$this->search.'%');
        }
        
        $this->teachers = $query->latest()->get();
    }

    public function updatedSearch()
    {
        $this->loadTeachers();
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'subject_id' => 'required',
            'class_level_id' => 'required',
        ]);

        // 1. Create the User Account for Login
        $defaultPassword = 'password'; // You can change this default password
        
        $user = User::create([
            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($defaultPassword),
            'role' => 'teacher'
        ]);

        // 2. Create the Teacher Profile
        Teacher::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject_id' => $this->subject_id,
            'class_level_id' => $this->class_level_id,
            'user_id' => $user->id, // Link them together
        ]);

        // 3. Show the Credentials to the Admin
        session()->flash('success_message', "Teacher registered successfully! \nLogin Email: {$this->email} \nPassword: {$defaultPassword}");
        
        // 4. Reset Form
        $this->first_name = ''; $this->last_name = ''; $this->email = '';
        $this->phone = ''; $this->subject_id = ''; $this->class_level_id = '';
        $this->loadTeachers();
    }

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher && $teacher->user_id) {
            User::find($teacher->user_id)->delete();
        }
        $teacher->delete();
        $this->loadTeachers();
    }

    public function render()
    {
        return view('livewire.teacher-manager');
    }
}