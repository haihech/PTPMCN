<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = 'phanquyen';
    protected $fillable = [
		'id', 'quyen_id', 'nhanvien_manv', 
	];

}
