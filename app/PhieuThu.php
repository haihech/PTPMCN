<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhieuThu extends Model
{
    protected $table = 'phieuthu';
    protected $fillable = [
		'id', 'ngaythu', 'khachhang_id', 'nhanvien_manv', 'phuongthucthanhtoan',
	];
}
