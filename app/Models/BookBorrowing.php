<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BookBorrowing extends Model {
    protected $fillable = ['book_id', 'student_id', 'borrow_date', 'return_date', 'status'];
    public function book() { return $this->belongsTo(Book::class); }
    public function student() { return $this->belongsTo(Student::class); }
}