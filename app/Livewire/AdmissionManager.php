<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AdmissionApplication;
use App\Models\Student;
use App\Models\User;
use App\Models\ClassLevel;
use App\Models\Section;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\Hash;

class AdmissionManager extends Component
{
    public $applications = [];
    public $selectedApp = null;
    public $showModal = false;

    public function mount()
    {
        $this->loadApplications();
    }

    public function loadApplications()
    {
        $this->applications = AdmissionApplication::latest()->get();
    }

    public function viewApp($id)
    {
        $this->selectedApp = AdmissionApplication::findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedApp = null;
    }

    public function approve($id)
    {
        $app = AdmissionApplication::findOrFail($id);

        if ($app->status !== 'Pending') {
            session()->flash('error', 'This application has already been processed.');
            $this->closeModal();
            return;
        }

        // 1. Safely find Class Level
        $classLevel = ClassLevel::where('name', $app->applying_for_class)->first();
        if (!$classLevel) {
            $classLevel = ClassLevel::first();
        }

        // 2. Safely find Section
        $sectionId = null;
        if ($classLevel) {
            $section = Section::where('class_level_id', $classLevel->id)->first();
            $sectionId = $section ? $section->id : null;
        }

        // 3. Safely find Active Session
        $sessionId = null;
        $session = AcademicSession::where('is_active', true)->first();
        if ($session) {
            $sessionId = $session->id;
        }

        // 4. Generate Admission Number
        $admNo = 'ADM-' . strtoupper(substr($app->first_name, 0, 2)) . rand(1000, 9999);

        // 5. Handle Parent Account
        $parentId = null;
        if ($app->parent_email) {
            $parentUser = User::where('email', $app->parent_email)->first();
            
            if (!$parentUser) {
                $parentUser = User::create([
                    'name' => $app->parent_name,
                    'email' => $app->parent_email,
                    'password' => Hash::make('password'),
                    'role' => 'parent'
                ]);
            }
            $parentId = $parentUser->id;
        }

        // 6. Create Student Record
        Student::create([
            'first_name' => $app->first_name,
            'last_name' => $app->last_name,
            'admission_number' => $admNo,
            'date_of_birth' => $app->date_of_birth,
            'gender' => $app->gender,
            'class_level_id' => $classLevel ? $classLevel->id : null,
            'section_id' => $sectionId,
            'academic_session_id' => $sessionId,
            'enrollment_year' => date('Y'),
            'parent_id' => $parentId,
        ]);

        // 7. Update Status
        $app->update(['status' => 'Approved']);

        session()->flash('message', "Success! {$app->first_name} {$app->last_name} approved. Admission No: {$admNo}. Parent login: {$app->parent_email} / password");
        $this->closeModal();
        $this->loadApplications();
    }

    public function reject($id)
    {
        $app = AdmissionApplication::findOrFail($id);
        $app->update(['status' => 'Rejected']);
        session()->flash('message', "Application for {$app->first_name} has been rejected.");
        $this->closeModal();
        $this->loadApplications();
    }

    public function render()
    {
        return view('livewire.admission-manager');
    }
}