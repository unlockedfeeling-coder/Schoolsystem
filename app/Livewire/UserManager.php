<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManager extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'teacher'; 
    public $users = [];

    public function mount() {
        $this->users = User::where('role', '!=', 'admin')->latest()->get();
    }

    public function save() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:teacher,parent,student', // UPDATED TO INCLUDE STUDENT
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password ?: 'password'), 
            'role' => $this->role,
        ]);

        session()->flash('message', 'Account created successfully! Default password is "password".');
        $this->reset(['name', 'email', 'password']);
        $this->users = User::where('role', '!=', 'admin')->latest()->get();
    }

    public function delete($id) {
        User::find($id)->delete();
        $this->users = User::where('role', '!=', 'admin')->latest()->get();
        session()->flash('message', 'User deleted.');
    }

    public function render() { 
        return view('livewire.user-manager'); 
    }
}