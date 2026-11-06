<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClassLevel;

class ClassLevelManager extends Component
{
    public $name = '';
    public $slug = '';
    public $sort_order = 0;
    public $levels = [];

    public function mount() { $this->loadLevels(); }

    public function loadLevels() { $this->levels = ClassLevel::orderBy('sort_order')->get(); }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:class_levels,slug',
        ]);

        ClassLevel::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'sort_order' => $this->sort_order,
        ]);

        session()->flash('message', 'Class Level created successfully!');
        $this->name = ''; $this->slug = ''; $this->sort_order = 0;
        $this->loadLevels();
    }

    public function render() { return view('livewire.class-level-manager'); }
}