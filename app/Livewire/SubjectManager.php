<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;

class SubjectManager extends Component
{
    public $name = '';
    public $code = '';
    public $subjects = [];

    public function mount() { 
        $this->loadSubjects(); 
    }

    public function loadSubjects() {
        $this->subjects = Subject::latest()->get();
    }

    public function save() {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects,code',
        ]);

        Subject::create([
            'name' => $this->name,
            'code' => $this->code,
        ]);

        session()->flash('message', 'Subject added successfully!');
        $this->reset(['name', 'code']);
        $this->loadSubjects();
    }

    public function delete($id) {
        Subject::find($id)->delete();
        session()->flash('message', 'Subject deleted.');
        $this->loadSubjects();
    }

    public function render() { 
        return view('livewire.subject-manager'); 
    }
}