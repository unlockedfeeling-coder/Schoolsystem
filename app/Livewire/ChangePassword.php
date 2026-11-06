<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password they typed is correct
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        // Update to the new password
        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('message', 'Password updated successfully! Please use your new password next time you log in.');
    }

    public function render()
    {
        return view('livewire.change-password');
    }
}