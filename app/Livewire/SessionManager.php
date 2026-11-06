<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AcademicSession;

class SessionManager extends Component
{
    public $name = '';
    public $start_date = '';
    public $end_date = '';
    public $sessions = [];

    public function mount()
    {
        $this->loadSessions();
    }

    public function loadSessions()
    {
        $this->sessions = AcademicSession::latest()->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:academic_sessions,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        AcademicSession::create([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => false,
        ]);

        $this->name = '';
        $this->start_date = '';
        $this->end_date = '';
        
        session()->flash('message', 'Academic Session added successfully!');
        $this->loadSessions();
    }

    public function setActive($id)
    {
        // Deactivate all sessions first
        AcademicSession::where('is_active', true)->update(['is_active' => false]);
        
        // Activate the selected session
        AcademicSession::where('id', $id)->update(['is_active' => true]);
        
        session()->flash('message', 'Session activated successfully!');
        $this->loadSessions();
    }

    public function delete($id)
    {
        AcademicSession::find($id)->delete();
        session()->flash('message', 'Session deleted.');
        $this->loadSessions();
    }

    public function render()
    {
        return view('livewire.session-manager');
    }
}