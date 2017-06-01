<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhieuChi extends Model
{
    protected $table = 'phieuchi';
    protected $fillable = [
		'id', 'ngaychi', 'nhanvien_manv', 'phuongthucthanhtoan',
	];
}
