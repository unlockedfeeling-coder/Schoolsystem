<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\Book;
use App\Models\Student;
use App\Models\BookBorrowing;

class LibraryManager extends Component
{
    public $books = [];
    public $students = [];
    public $borrowings = [];
    
    // Add Book Properties
    public $title = ''; public $author = ''; public $isbn = ''; public $total_copies = '';
    
    // Issue Book Properties
    public $issue_student_id = ''; public $issue_book_id = ''; public $issue_date = '';

    public function mount() { $this->loadData(); }

    public function loadData() {
        $this->books = Book::latest()->get();
        $this->students = Student::latest()->get();
        $this->borrowings = BookBorrowing::with(['book', 'student'])->latest()->get();
    }

    public function addBook() {
        $this->validate([
            'title' => 'required', 'author' => 'required', 'isbn' => 'required|unique:books,isbn', 'total_copies' => 'required|integer|min:1'
        ]);
        Book::create([
            'title' => $this->title, 'author' => $this->author, 'isbn' => $this->isbn,
            'total_copies' => $this->total_copies, 'available_copies' => $this->total_copies
        ]);
        session()->flash('message', 'Book added successfully!');
        $this->reset(['title', 'author', 'isbn', 'total_copies']);
        $this->loadData();
    }

    public function issueBook() {
        $this->validate(['issue_student_id' => 'required', 'issue_book_id' => 'required', 'issue_date' => 'required|date']);
        
        $book = Book::find($this->issue_book_id);
        if ($book->available_copies <= 0) {
            session()->flash('error', 'No copies available for this book!');
            return;
        }

        BookBorrowing::create([
            'book_id' => $this->issue_book_id, 'student_id' => $this->issue_student_id,
            'borrow_date' => $this->issue_date, 'status' => 'Borrowed'
        ]);
        $book->decrement('available_copies');
        
        session()->flash('message', 'Book issued successfully!');
        $this->reset(['issue_student_id', 'issue_book_id', 'issue_date']);
        $this->loadData();
    }

    public function returnBook($id) {
        $borrowing = BookBorrowing::find($id);
        if ($borrowing && $borrowing->status === 'Borrowed') {
            $borrowing->update(['status' => 'Returned', 'return_date' => now()->format('Y-m-d')]);
            $borrowing->book->increment('available_copies');
            session()->flash('message', 'Book returned successfully!');
            $this->loadData();
        }
    }

    public function render() { return view('livewire.library-manager'); }
}