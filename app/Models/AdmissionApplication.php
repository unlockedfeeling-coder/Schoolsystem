<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionApplication extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'passport_photo',
        'parent_name',
        'parent_phone',
        'parent_email',
        'previous_school',
        'applying_for_class',
        'status',
    ];
}