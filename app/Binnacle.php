<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $fillable = [
		'user_id','action','identity','type'
    ];

    public function user()
    {
    	return $this->belongsTo(\App\User::class);
    }
}
