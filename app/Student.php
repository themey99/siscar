<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
		'identity',
		'first_name',
		'first_s_name',
		'last_name',
		'last_s_name',
		'gender',
		'birthdate',
        'phone',
        'email',
    ];

    public function careers()
    {
    	return $this->belongsToMany(Career::class,'student_career')
            ->withPivot('photo', 'photo_license_2')
            ->withTimestamps();
    }
    
    public function licenses()
    {
        return $this->hasMany(Licenses::class);
    }
}