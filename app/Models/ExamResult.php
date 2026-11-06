<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model {
    protected $fillable = [
        'student_id', 
        'subject_id', 
        'exam_type', 
        'class_score', 
        'exam_score', 
        'total_score', 
        'marks', 
        'position', 
        'subject_position'
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
}