<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class PayController extends Controller
{
    public function indexPay(){

        return view('web-bansua-admin.deposit-pay.chitien');
    }

    public function autoCompleteOrder(Request $request){
    	
        $query = $request->get('term');
        
        $orders = DB::table('hoadonnhap')
                    ->join('nhacungcap', 'nhacungcap.id', '=', 'hoadonnhap.nhacungcap_id')
                    ->join('chitietnhap', 'hoadonnhap.id', '=', 'chitietnhap.hoadonnhap_id')
                    ->where('hoadonnhap.id', 'LIKE', '%'.$query.'%')
                    ->select('nhacungcap.ten','hoadonnhap.id', DB::raw('sum(chitietnhap.soluong*chitietnhap.gianhap) AS total_sales'))

                   ->groupBy('hoadonnhap.id', 'nhacungcap.ten')
                   ->take(5)
                   ->get();
        
        $data=array();
        foreach ($orders as $order) {
                $data[]=array('value'=>'Mã HĐ -- '.$order->id.' -- '.$order->total_sales.' -- '.$order->ten);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }


    public function createPay(Request $request){
        if($request->ajax()){
            $user_id = Session::get('admin')->manv;
            $key = $request->key_save;
            
            if(strpos($key, " ++ ") !== false){
                $list = explode(' ++ ', $key);

                $listCount = count($list);
                $date = $list[0];
                $type = $list[3];
                $nhacungcap = DB::table('nhacungcap')->where('nhacungcap.ten', $list[2])->value('id');
                
                DB::table('phieuchi')->insert(
                    ['phuongthucthanhtoan' => $type,
                     'nhanvien_manv' => $user_id,
                     'ngaychi' => $date,
                     'nhacungcap_id' => $nhacungcap,
                    ]
                );

                $pay_id = DB::table('phieuchi')->max('id');
                

                for($i = 0; $i < $listCount - 1; $i = $i+6){
                    $money = $list[$i+5];
                    $list1 = explode(",", $money);
                    $money_pay = '';
                    foreach ($list1 as $value) {
                        $money_pay .= $value;
                    }
                    DB::table('chitietchi')->insert(
                        ['sotienchi' => $money_pay,
                         'hoadonnhap_id' => $list[$i+1],
                         'phieuchi_id' => $pay_id,
                        ]
                    );
                }
                

                return Response('Lưu thành công');
            }
        }
    }

}
