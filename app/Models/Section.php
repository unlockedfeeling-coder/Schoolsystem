<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'class_level_id',
        'name',
        'capacity',
    ];

    public function classLevel()
    {
        return $this->belongsTo(ClassLevel::class);
    }
}