<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    protected $table = 'thuonghieu';
    protected $fillable = [
		'id', 'ten', 'nuoc', 'anh', 
	];
	public function getAll(){
		return $this->get();
	}
	public function sanpham(){
		return $this->hasMany('App\SanPham','thuonghieu_id');
	}
}
