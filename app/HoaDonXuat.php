<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoaDonXuat extends Model
{
    protected $table = 'hoadonxuat';
    protected $fillable = [
		'id', 'khachhang_id', 'diachigiaohang','phuongthucthanhtoan', 'thanhtoan', 'phiship', 'trangthai', 'updated_at', 'created_at', 'nguoixuatkho', 'nguoigiaohang', 'note', 'ngaygiaohang',
	];

	
}
