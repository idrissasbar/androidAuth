<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use SoftDeletes;
	
	protected $table = 'uploads';
	
	protected $hidden = [
        'getOwner'
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	/**
     * Get the user that owns upload.
     */
    public function getOwner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    /**
     * Get File path
     */
    public function path()
    {
        return url("api/v1/files/".$this->hash."/".$this->name);
    }


}
