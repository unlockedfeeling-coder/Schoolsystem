<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model {
    protected $fillable = ['student_id', 'fee_type_id', 'academic_session_id', 'amount_paid', 'payment_method', 'reference_number', 'payment_date'];
    
    public function student() { return $this->belongsTo(Student::class); }
    public function feeType() { return $this->belongsTo(FeeType::class); }
    public function session() { return $this->belongsTo(AcademicSession::class); }
}