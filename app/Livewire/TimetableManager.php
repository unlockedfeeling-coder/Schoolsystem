<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Timetable;
use App\Models\ClassLevel;
use App\Models\Subject;
use App\Models\Teacher;

class TimetableManager extends Component
{
    public $class_level_id = '';
    public $subject_id = '';
    public $teacher_id = '';
    public $day_of_week = 'Monday';
    public $start_time = '';
    public $end_time = '';
    
    public $timetables = [];
    public $classLevels = [];
    public $subjects = [];
    public $teachers = [];

    public function mount() { $this->loadData(); }

    public function loadData()
    {
        $this->classLevels = ClassLevel::all();
        $this->subjects = Subject::all();
        $this->teachers = Teacher::all();
        $this->timetables = Timetable::with(['classLevel', 'subject', 'teacher'])->orderBy('day_of_week')->get();
    }

    public function save()
    {
        $this->validate([
            'class_level_id' => 'required',
            'subject_id' => 'required',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Timetable::create([
            'class_level_id' => $this->class_level_id,
            'subject_id' => $this->subject_id,
            'teacher_id' => $this->teacher_id ?: null,
            'day_of_week' => $this->day_of_week,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        session()->flash('message', 'Timetable entry added!');
        $this->reset(['class_level_id', 'subject_id', 'teacher_id', 'start_time', 'end_time']);
        $this->loadData();
    }

    public function delete($id)
    {
        Timetable::find($id)->delete();
        session()->flash('message', 'Entry deleted.');
        $this->loadData();
    }

    public function render() { return view('livewire.timetable-manager'); }
}