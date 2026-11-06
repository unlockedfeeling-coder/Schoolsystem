<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AcademicSession;

class AcademicSessionManager extends Component
{
    public $name = '';
    public $start_date = '';
    public $end_date = '';
    public $sessions = [];

    public function mount() { $this->loadSessions(); }

    public function loadSessions()
    {
        $this->sessions = AcademicSession::orderBy('start_date', 'desc')->get();
    }

    public function save()
    {
        // 1. Validate the data
        $this->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ], [
            'name.required' => 'Please enter a session name.',
            'start_date.required' => 'Please select a start date.',
            'end_date.required' => 'Please select an end date.',
            'end_date.after' => 'The end date must be after the start date.',
        ]);

        // 2. Check if this is the first session
        $isActive = AcademicSession::count() === 0;

        // 3. Save to database
        AcademicSession::create([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $isActive, 
        ]);

        session()->flash('message', 'Session created successfully!');
        
        // 4. Reset form
        $this->name = ''; 
        $this->start_date = ''; 
        $this->end_date = '';
        $this->loadSessions();
    }

    public function setActive($id)
    {
        AcademicSession::query()->update(['is_active' => false]);
        AcademicSession::find($id)->update(['is_active' => true]);
        session()->flash('message', 'Session set as Active successfully!');
        $this->loadSessions();
    }

    public function delete($id)
    {
        AcademicSession::find($id)->delete();
        session()->flash('message', 'Session deleted.');
        $this->loadSessions();
    }

    public function render() { return view('livewire.academic-session-manager'); }
}