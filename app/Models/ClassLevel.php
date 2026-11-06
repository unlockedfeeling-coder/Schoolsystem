<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassLevel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}