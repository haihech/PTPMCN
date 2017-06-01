<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    protected $table = 'khuyenmai';
    protected $fillable = [
		'id', 'tungay', 'denngay', 'noidung', 'sanpham_id',
	];
	public function getSanPham()
    {
        return $this->hasOne('App\SanPham','fk_km_sp');
    }
}
