<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\TinTuc;
use App\KhuyenMai;
use App\ThuongHieu;
use App\NhomTuoi;
use App\SanPham;
    use App\ChiTietXuat;
class AdvertiseController extends Controller
{
    public function loadSlide(){
        $slide=Slide::where('active',1)->get(['anh','link']);
        return view('layouts.slide_top',compact('slide'));
    }
     public function loadNews(){
        $news=TinTuc::where('active',1)->get(['anh','tieude']);
        return view('layouts.tintuc',compact('news'));
    }
    public function getKhuyenMai($index=0){
            $spkhuyenmai=KhuyenMai::where('denngay','>',date('Y-m-d'))->orderBy('denngay','asc')->skip($index)->take(20)->get(['sanpham_id']);
            $list=[];
            foreach ($spkhuyenmai as $sp){
                $x=SanPham::find($sp->sanpham_id);
                $x->km=1;
                array_push($list, $x);
            }
            return $list;
    }
     public function loadKhuyenMai($b,$index=0){
        $list=$this->getKhuyenMai($index);
        if(!$b){
            $classN="productKhuyenMai";
             return view('layouts.product',compact('list','classN'))->with('show_khuyenmai','');
        }
        else $classN='eProduct';
        return view('layouts.product',compact('list','classN'))->with('show_cart','');
    }
         public function getStartAndEndDateWeek($week, $year)
        {
            $time = strtotime("1 January $year", time());
            $day = date('w', $time);
            $time += ((7*$week)+1-$day)*24*3600;
            $return[0] = date('Y-n-j', $time);
            $time += 6*24*3600;
            $return[1] = date('Y-n-j', $time);
            return $return;
        }
        public function getStartAndEndDateMonth($month, $year){
            $return[0]=date('Y-m-d',  strtotime("first day of last month")); 
             $return[1]=date('Y-m-t',  strtotime("last day of last month")); 
             return $return;
         }
        //lấy hàng bán chạy time={tuan trước,thang trước} max 10 sp
        public function getHotProduct($time='w',$b,$index=0){
            $month= date("m");
            $week=date('W');
            $year=date('Y');
            if($week>0){
                $week--;
            }else{
                $week=52;
                $year--;
            }
            if($month>0){
                $month--;
            }else {
                $month=12;
                $year--;
            }
            if($time=='w') $day= $this->getStartAndEndDateWeek($week,$year);
            else $day= $this->getStartAndEndDateMonth($month,$year);
          
            $arr= ChiTietXuat::whereBetween('created_at',$day)->groupBy('sanpham_id')->select('sanpham_id', \DB::raw('count(*) as total'))->orderBy('total','desc')->skip($index)->take(10)->get('sanpham_id');
            $list=[];
            foreach ($arr as $key => $e) {
               $list[$key]=$this->checkKhuyenMai(SanPham::find($e->sanpham_id));
            }
            if(!$b){
                 $classN="productKhuyenMai";
                 return view('layouts.product',compact('list','classN'));
            }else{
                $classN="eProduct";
                 return view('layouts.product',compact('list','classN'))->with('show_cart','');
            }
            
        }
        public function checkKhuyenMai($sp){
            $n=(clone $sp);
            $sp->km=count($n->khuyenmai);
            return $sp;
        }

}
