<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $fillable = [
		'id', 'ten', 'giaban', 'anh', 'nhomtuoi_id', 'thuonghieu_id', 'discount', 'mota',
	];

	public function getAllProduct(){
		$a = [];
		$sanpham = $this::All();
		foreach ($sanpham as $s) {
			array_push($a, $s);
		}
		return $a;
	}

    public function getSomeProducts($index=0,$nums=0,$thuonghieu=-1,$nhomtuoi=-1,$giamgia=-1){
        if($thuonghieu==-1&&$nhomtuoi==-1&&$giamgia==-1){
            return $this->skip($index)->take($nums)->get();
        }else if($thuonghieu==-1&&$nhomtuoi!=-1&&$giamgia==-1){
            return $this->where('nhomtuoi_id',$nhomtuoi)->skip($index)->take($nums)->get();
        }else if($thuonghieu!=-1&&$nhomtuoi==-1&&$giamgia==-1){
            return $this->where('thuonghieu_id',$thuonghieu)->skip($index)->take($nums)->get();
        }else if($thuonghieu==-1&&$nhomtuoi==-1&&$giamgia!=-1){
            return $this->where('discount','>',0)->skip($index)->take($nums)->get();
        }else if($thuonghieu!=-1&&$nhomtuoi!=-1&&$giamgia==-1){
            return $this->where('thuonghieu_id',$thuonghieu)->where('nhomtuoi_id',$nhomtuoi)->skip($index)->take($nums)->get();
        }else if($thuonghieu!=-1&&$nhomtuoi==-1&&$giamgia!=-1){
            return $this->where('thuonghieu_id',$thuonghieu)->where('discount','>',0)->skip($index)->take($nums)->get();
        }else if($thuonghieu==-1&&$nhomtuoi!=-1&&$giamgia!=-1){
            return $this->where('discount','>',0)->where('nhomtuoi_id',$nhomtuoi)->skip($index)->take($nums)->get();
        }else{
            return $this->where('nhomtuoi_id',$nhomtuoi)->where('thuonghieu_id',$thuonghieu)->where('discount','>',0)->skip($index)->take($nums)->get();
        }
	}
    public function getProduct($id){
    	return $this::where('id',$id)->first();
    }
    public function khuyenmai(){
    	return $this->hasMany('App\KhuyenMai','sanpham_id');
    }
    
}


