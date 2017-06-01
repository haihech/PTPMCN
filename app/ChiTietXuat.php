<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiTietXuat extends Model
{
    protected $table = 'chitietxuat';
    protected $fillable = [
		'id', 'soluong', 'giaban', 'hoadonxuat_id',  'sanpham_id', 'hansudung', 'updated_at', 'created_at',
	];
}
