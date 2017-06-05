<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PhanQuyen extends Model
{
    protected $table = 'phanquyen';
    protected $fillable = [
		'id', 'quyen_id', 'nhanvien_manv', 
	];

	public function getShipper(){
		$shipper = DB::table('phanquyen')
                    ->where('quyen_id', "quyen-17")
                    ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                    ->select('nhanvien.*')->get();

        return $shipper;
	}

}

