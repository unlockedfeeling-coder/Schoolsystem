<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    protected $fillable = [
        'first_name', 'last_name', 'admission_number', 'date_of_birth', 'gender',
        'class_level_id', 'section_id', 'academic_session_id', 'enrollment_year', 'parent_id'
    ];

    public function classLevel() { return $this->belongsTo(ClassLevel::class); }
    public function section() { return $this->belongsTo(Section::class); }
    public function parent() { return $this->belongsTo(User::class, 'parent_id'); }
    
    // NEW RELATIONSHIP FOR FEE PAYMENTS
    public function payments() { return $this->hasMany(FeePayment::class); }
}