<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoaDonNhap extends Model
{
    protected $table = 'hoadonnhap';
    protected $fillable = [
		'id', 'nhacungcap_id', 'manv', 'updated_at', 'created_at',
	];
}
