<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\AdmissionApplication;

class AdmissionForm extends Component
{
    use WithFileUploads;

    public $first_name = ''; public $last_name = ''; public $date_of_birth = '';
    public $gender = ''; public $passport_photo; 
    public $parent_name = ''; public $parent_phone = ''; public $parent_email = '';
    public $previous_school = ''; public $applying_for_class = '';

    public function save()
    {
        $this->validate([
            'first_name' => 'required', 'last_name' => 'required', 'date_of_birth' => 'required|date',
            'gender' => 'required', 'passport_photo' => 'required|image|max:2048',
            'parent_name' => 'required', 'parent_phone' => 'required', 'applying_for_class' => 'required',
        ]);

        $photoPath = $this->passport_photo->store('passport_photos', 'public');

        AdmissionApplication::create([
            'first_name' => $this->first_name, 'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth, 'gender' => $this->gender,
            'passport_photo' => $photoPath, 'parent_name' => $this->parent_name,
            'parent_phone' => $this->parent_phone, 'parent_email' => $this->parent_email,
            'previous_school' => $this->previous_school, 'applying_for_class' => $this->applying_for_class,
        ]);

        session()->flash('message', 'Application submitted successfully! The school will review it and contact you.');
        $this->reset();
    }

    public function render() { return view('livewire.admission-form'); }
}