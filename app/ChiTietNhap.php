<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietNhap extends Model
{
    protected $table = 'chitietnhap';
    protected $fillable = [
		'id', 'hoadonnhap_id', 'gianhap', 'soluong', 'sanpham_id','hansudung', 'updated_at', 'created_at',
	];
}
