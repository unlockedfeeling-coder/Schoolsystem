<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementManager extends Component
{
    use WithFileUploads;

    public $title = '';
    public $content = '';
    public $date = '';
    public $image;
    public $announcements = [];

    public function mount() { 
        $this->loadAnnouncements(); 
    }

    public function loadAnnouncements() {
        $this->announcements = Announcement::orderBy('date', 'desc')->get();
    }

    public function save() {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('announcements', 'public');
        }

        Announcement::create([
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Announcement published successfully!');
        $this->reset(['title', 'content', 'date', 'image']);
        $this->loadAnnouncements();
    }

    public function delete($id) {
        $announcement = Announcement::find($id);
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        $announcement->delete();
        session()->flash('message', 'Announcement deleted.');
        $this->loadAnnouncements();
    }

    public function render() { 
        return view('livewire.announcement-manager'); 
    }
}