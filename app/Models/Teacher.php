<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 
        'subject_id', 'class_level_id', 'user_id'
    ];

    public function subject() { return $this->belongsTo(Subject::class); }
    public function classLevel() { return $this->belongsTo(ClassLevel::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function timetableEntries() { return $this->hasMany(Timetable::class); }
}