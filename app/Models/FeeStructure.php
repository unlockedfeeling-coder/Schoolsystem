<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model {
    protected $fillable = ['fee_type_id', 'class_level_id', 'academic_session_id', 'amount'];
    
    public function feeType() { return $this->belongsTo(FeeType::class); }
    public function classLevel() { return $this->belongsTo(ClassLevel::class); }
    public function session() { return $this->belongsTo(AcademicSession::class); }
}