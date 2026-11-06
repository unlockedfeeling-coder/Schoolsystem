<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'student_id', 'amount', 'status', 'due_date', 'paid_date'
    ];

    public function student() { return $this->belongsTo(Student::class); }
}