<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'giohang';
    protected $fillable = [
		'id', 'soluong', 'created_at', 'updated_at', 'khachhang_id', 'sanpham_id',
	];
}
