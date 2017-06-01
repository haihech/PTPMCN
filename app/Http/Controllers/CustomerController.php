<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use App\SanPham;
use Session;
use App\GioHang;
use App\Cart;
use DB;

class CustomerController extends Controller
{
     public function get_infor_customer(Request $request){
      
        $list_customer = DB::table('users')->take(10)->get(); 
        foreach ($list_customer as $value) {
          $list = DB::table('hoadonxuat')->where('hoadonxuat.khachhang_id', $value->id)
                      ->join('chitietxuat', 'chitietxuat.hoadonxuat_id', '=', 'hoadonxuat.id')
                      ->select('hoadonxuat.id', 'hoadonxuat.trangthai', 'hoadonxuat.phiship', 'hoadonxuat.created_at', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                      ->groupBy('hoadonxuat.id', 'hoadonxuat.trangthai', 'hoadonxuat.phiship', 'hoadonxuat.created_at')
                      ->get();

          $arr[$value->id] = $list;
        }    
        $key = null;
         return view('web-bansua-admin.customer.danhsachkhachhang', ['listCustomer' => $list_customer, 'keySearch' => $key,'arr' => $arr]);
     }
      public function searchCustomerByKey(Request $request){

        $key = $request->input('search');
         $list_customer = DB::table('users')->select(DB::raw('users.*'))   
                                              ->where('id', 'LIKE', "%{$key}%")  
                                              ->orWhere( 'ten', 'LIKE', "%{$key}%")
                                              ->orWhere( 'sdt', 'LIKE', "%{$key}%")
                                              ->take(10)->get();
        $arr = array();                                        
        foreach ($list_customer as $value) {
          $list = DB::table('hoadonxuat')->where('hoadonxuat.khachhang_id', $value->id)
                      ->join('chitietxuat', 'chitietxuat.hoadonxuat_id', '=', 'hoadonxuat.id')
                      ->select('hoadonxuat.id', 'hoadonxuat.trangthai', 'hoadonxuat.phiship', 'hoadonxuat.created_at', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                      ->groupBy('hoadonxuat.id', 'hoadonxuat.trangthai', 'hoadonxuat.phiship', 'hoadonxuat.created_at')
                      ->get();
          $arr[$value->id] = $list;
        }
        return view('web-bansua-admin.customer.danhsachkhachhang', ['listCustomer' => $list_customer, 'keySearch' => $key,'arr' => $arr]);
    }

}
