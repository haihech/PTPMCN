<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoHoaDon extends Model
{
    protected $table = 'sohoadon';
    protected $fillable = [
		'sohoadon', 'donhang_id', 
	];
}
