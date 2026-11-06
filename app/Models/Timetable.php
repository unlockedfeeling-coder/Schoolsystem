<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model {
    protected $fillable = [
        'day', 'start_time', 'end_time', 
        'subject_id', 'class_level_id', 'teacher_id', 'room'
    ];

    public function subject() { return $this->belongsTo(Subject::class); }
    public function classLevel() { return $this->belongsTo(ClassLevel::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
}