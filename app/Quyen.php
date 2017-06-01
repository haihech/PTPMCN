<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    protected $table = 'quyen';
    protected $fillable = [
		'id', 'tenquyen', 
	];

	
}
