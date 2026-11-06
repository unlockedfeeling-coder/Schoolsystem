<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            
            if (auth()->user()->role === 'teacher') {
                return redirect()->intended('/teacher/dashboard');
            }
            
            if (auth()->user()->role === 'parent') {
                return redirect()->intended('/parent/dashboard');
            }
            
            return redirect()->intended('/');
        }

        session()->flash('error', 'Invalid email or password.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}