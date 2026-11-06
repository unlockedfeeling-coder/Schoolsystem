<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Section;
use App\Models\ClassLevel;

class SectionManager extends Component
{
    public $name = '';
    public $class_level_id = '';
    public $capacity = '';
    public $editing_id = null; // Tracks if we are editing a section
    
    public $sections = [];
    public $classLevels = [];

    public function mount()
    {
        $this->classLevels = ClassLevel::all();
        $this->loadSections();
    }

    public function loadSections()
    {
        // Load sections and include the class name
        $this->sections = Section::with('classLevel')->latest()->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'class_level_id' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        Section::create([
            'name' => $this->name,
            'class_level_id' => $this->class_level_id,
            'capacity' => $this->capacity,
        ]);

        session()->flash('message', 'Section added successfully!');
        $this->resetForm();
        $this->loadSections();
    }

    public function edit($id)
    {
        $section = Section::find($id);
        if ($section) {
            $this->editing_id = $id;
            $this->name = $section->name;
            $this->class_level_id = $section->class_level_id;
            $this->capacity = $section->capacity;
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'class_level_id' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        Section::find($this->editing_id)->update([
            'name' => $this->name,
            'class_level_id' => $this->class_level_id,
            'capacity' => $this->capacity,
        ]);

        session()->flash('message', 'Section updated successfully!');
        $this->resetForm();
        $this->loadSections();
    }

    public function delete($id)
    {
        Section::find($id)->delete();
        session()->flash('message', 'Section deleted.');
        $this->loadSections();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->class_level_id = '';
        $this->capacity = '';
        $this->editing_id = null;
    }

    public function render() { return view('livewire.section-manager'); }
}