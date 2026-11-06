<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model {
    protected $fillable = ['name'];
    public function structures() { return $this->hasMany(FeeStructure::class); }
    public function payments() { return $this->hasMany(FeePayment::class); }
}