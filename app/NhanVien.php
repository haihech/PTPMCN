<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhanvien';
    protected $fillable = [
		'manv', 'password', 'ten', 'sdt', 'cmt', 'diachi', 'chucvu', 'status', 'img',
	];

	public function getStaff($idstaff){
		return $this::where('manv',$idstaff)->get();
	}

	public function getAllStaff($idstaff){
		return $this::All();
	}
}
