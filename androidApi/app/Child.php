<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
	protected $table = 'childrens';

    protected $fillable = [
        'name', 'birthdate'
    ];
    

 	public function getUser()
   {
        return $this->belongsTo(User::class,'user_id');
    }
	
}
