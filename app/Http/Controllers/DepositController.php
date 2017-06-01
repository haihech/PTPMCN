<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\HoaDonXuat;

class DepositController extends Controller
{
    public function indexDeposit(){
        $giaohang = DB::table('phanquyen')
                    ->where('quyen_id', "quyen-17")
                    ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                    ->select('nhanvien.*')->get();
        $arr = null;
        $arrTT = null;
        return view('web-bansua-admin.deposit-pay.thutien_v2', ['arr' => $arr, 'arrTT' => $arrTT, 'giaohang' => $giaohang]);
    }

    public function search(){
        $selected = $_GET['option_selected'];
        if($selected === 'Chọn người giao hàng'){
           
        }
        else{
            $id = explode(' - ', $selected);
            $orders = DB::table('hoadonxuat')->where('trangthai', 'Đã xuất kho')
                    ->where('nguoigiaohang', $id[1])
                    ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')

                    ->select('users.ten as tenkh', 'nhanvien.ten as tennv', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship','nhanvien.ten')
                    ->get();
            $STT = 0;
            $arr = array();
            $arrTT = array();     
            foreach ($orders as $value) {
                $dathanhtoan = DB::table('chitietthu')->where('chitietthu.hoadonxuat_id', $value->id)
                            ->sum('chitietthu.sotienthu');
                if($dathanhtoan < ($value->total_sales+$value->phiship)){
                    array_push($arr, $value);
                    array_push($arrTT, $value->total_sales+$value->phiship-$dathanhtoan);
                }
            }
            
            $giaohang = DB::table('phanquyen')
                        ->where('quyen_id', "quyen-17")
                        ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                        ->select('nhanvien.*')->get();
            
            return view('web-bansua-admin.deposit-pay.thutien_v2', ['arr' => $arr, 'arrTT' => $arrTT, 'giaohang' => $giaohang]);
        }
                
           
        return redirect()->back();
    }

    public function createDeposit(Request $request, $pttt, $ngaythu, $sotienthu){
        $data = $request->key;
        $user_id = Session::get('admin')->manv;

        DB::table('phieuthu')->insert(
                    ['phuongthucthanhtoan' => $pttt,
                     'nhanvien_manv' => $user_id,
                     'ngaythu' => $ngaythu,
                    ]
                );
        $list = explode('++', $data);
        $countList = count($list);
        for($i = 0; $i < $countList-1; $i++){
            $order = explode('--', $list[$i]);
            // $order = DB::table('hoadonxuat')->where('hoadonxuat.id', $list[$i])
            //         ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
            //         ->select('hoadonxuat.id','hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
            //         ->groupBy('hoadonxuat.id', 'hoadonxuat.phiship')
            //         ->get();

            $deposit_id = DB::table('phieuthu')->max('id');
            $socanthu = (int)$order[1];

            if($sotienthu < $socanthu){
                DB::table('chitietthu')->insert(
                        ['sotienthu' => $sotienthu,
                         'hoadonxuat_id' => $order[0],
                         'phieuthu_id' => $deposit_id,
                        ]
                    );
                break;
            }
            elseif ($sotienthu == $socanthu) {
                DB::table('chitietthu')->insert(
                        ['sotienthu' => $socanthu,
                         'hoadonxuat_id' => $order[0],
                         'phieuthu_id' => $deposit_id,
                        ]
                    );
                DB::table('hoadonxuat')->where('hoadonxuat.id', $order[0])->update(
                        ['hoadonxuat.trangthai' => 'Thành công']
                    );
                break;
            }
            else{
                if($i == $countList-2){
                    DB::table('chitietthu')->insert(
                        ['sotienthu' => $sotienthu,
                         'hoadonxuat_id' => $order[0],
                         'phieuthu_id' => $deposit_id,
                        ]
                    );
                }
                else{
                    DB::table('chitietthu')->insert(
                        ['sotienthu' => $socanthu,
                         'hoadonxuat_id' => $order[0],
                         'phieuthu_id' => $deposit_id,
                        ]
                    );
                    $sotienthu -= $socanthu;
                }
                
                DB::table('hoadonxuat')->where('hoadonxuat.id', $order[0])->update(
                        ['hoadonxuat.trangthai' => 'Thành công']
                    );
                
            }
        }

        return Response('Thành công!');
    }


    public function autoComplete(Request $request){
        $query = $request->get('term');
        
        $users = DB::table('users')
                    ->where('users.ten', 'LIKE', '%'.$query.'%')
                    ->orderBy('users.ten', 'asc')
                    ->take(10)
                    ->get();
        
        $data = array();
        foreach ($users as $user) {
                $data[]=array('value'=>'Mã -- '.$user->id.' -- '.$user->ten.' sđt: '.$user->sdt);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }

    public function autoCompleteOrder(Request $request){
        $query = $request->get('term');
        
        $orders = HoaDonXuat::join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->where('hoadonxuat.id', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.ten', 'LIKE', '%'.$query.'%')
                    ->select('users.ten as tenkh', 'nhanvien.ten as tennv','hoadonxuat.id', 'hoadonxuat.trangthai','hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                   ->groupBy('hoadonxuat.id', 'users.ten', 'nhanvien.ten','hoadonxuat.trangthai', 'hoadonxuat.phiship')
                    ->take(6)
                    ->get();
        
        $data=array();
        foreach ($orders as $order) {
                $sum = $order->total_sales + $order->phiship;
                $data[]=array('value'=>'Mã ĐH -- '.$order->id.' -- KH: '.$order->tenkh.' -- '.$order->trangthai.' -- '.$order->tennv.' -- '.$sum);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }

    // public function createDeposit(Request $request){
    //     if($request->ajax()){
    //         $user_id = Session::get('admin')->manv;
    //         $key = $request->key_save;
            
    //         if(strpos($key, " ++ ") !== false){
    //             $list = explode(' ++ ', $key);

    //             $listCount = count($list);
    //             $date = $list[0];
    //             $customer_id = $list[2];
    //             $type = $list[5];

    //             DB::table('phieuthu')->insert(
    //                 ['phuongthucthanhtoan' => $type,
    //                  'khachhang_id' => $customer_id,
    //                  'nhanvien_manv' => $user_id,
    //                  'ngaythu' => $date,
    //                 ]
    //             );

    //             $deposit_id = DB::table('phieuthu')->max('id');
                

    //             for($i = 0; $i < $listCount - 1; $i = $i+8){
    //                 $money = $list[$i+7];
    //                 $list1 = explode(",", $money);
    //                 $money_deposit = '';
    //                 foreach ($list1 as $value) {
    //                     $money_deposit .= $value;
    //                 }

    //                 DB::table('chitietthu')->insert(
    //                     ['sotienthu' => $money_deposit,
    //                      'hoadonxuat_id' => $list[$i+1],
    //                      'phieuthu_id' => $deposit_id,
    //                     ]
    //                 );
    //             }
                

    //             return Response('Lưu thành công');
    //         }
    //     }
    // }


    public function listIndex(){
        $arrOption = ['Phiếu thu', 'Phiếu chi'];
        $listDeposit = null;
        $arrDeposit = null;
        $listPay = null;
        $arrPay = null;
        $pay = false;
        $deposit = false;
        return view('web-bansua-admin.deposit-pay.danhsachthuchi', ['listDeposit' => $listDeposit, 'arrDeposit' => $arrDeposit, 'arrOption' => $arrOption, 'listPay' => $listPay, 'arrPay' => $arrPay, 'pay' => $pay, 'deposit' => $deposit]);
    }

    public function searchDepositAndPay(){
        if(isset($_GET['search'])){
            $option = $_GET['option_selected'];
            $query = $_GET['search_key'];
            $listDeposit = null;
            $arrDeposit = array();
            $listPay = null;
            $arrPay = array();
            $pay = false;
            $deposit = false;

            if($option == 'Phiếu thu'){
                $arrOption = ['Phiếu thu', 'Phiếu chi'];
                $listDeposit = DB::table('phieuthu')->where('phieuthu.id', $query)
                        ->join('chitietthu', 'phieuthu.id', '=', 'chitietthu.phieuthu_id')
                        ->select('phieuthu.id','phieuthu.ngaythu','phieuthu.phuongthucthanhtoan', DB::raw('sum(chitietthu.sotienthu) AS total_deposit'))

                        ->groupBy('phieuthu.id','phieuthu.ngaythu', 'phieuthu.phuongthucthanhtoan')
                        ->get();
                
                foreach ($listDeposit as $order) {
                    $orderDetails = DB::table('chitietthu')->where('phieuthu_id', $order->id)
                            ->join('hoadonxuat', 'chitietthu.hoadonxuat_id', '=', 'hoadonxuat.id')
                            ->join('chitietxuat', 'chitietxuat.hoadonxuat_id', '=', 'hoadonxuat.id')
                            ->select('chitietthu.sotienthu', 'chitietthu.hoadonxuat_id', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                            ->groupBy('chitietthu.sotienthu', 'chitietthu.hoadonxuat_id', 'hoadonxuat.phiship')
                            ->get();
                    $arrDeposit[$order->id] = $orderDetails;
                }
                $count = count($listDeposit);
                if($count > 0){
                    $deposit = true;
                }

                return view('web-bansua-admin.deposit-pay.danhsachthuchi', ['listDeposit' => $listDeposit, 'arrDeposit' => $arrDeposit, 'arrOption' => $arrOption, 'listPay' => $listPay, 'arrPay' => $arrPay, 'pay' => $pay, 'deposit' => $deposit]);

            }
            else if($option == 'Phiếu chi'){
                $arrOption = ['Phiếu chi', 'Phiếu thu'];
                $listPay = DB::table('phieuchi')->where('phieuchi.id', $query)
                        ->join('nhacungcap', 'nhacungcap.id', '=', 'phieuchi.nhacungcap_id')
                        ->join('chitietchi', 'phieuchi.id', '=', 'chitietchi.phieuchi_id')
                        ->select('nhacungcap.ten as ncc', 'phieuchi.id','phieuchi.ngaychi','phieuchi.phuongthucthanhtoan', DB::raw('sum(chitietchi.sotienchi) AS total_pay'))

                        ->groupBy('nhacungcap.ten', 'phieuchi.id','phieuchi.ngaychi', 'phieuchi.phuongthucthanhtoan')
                        ->get();
                
                foreach ($listPay as $order) {
                    $orderDetails = DB::table('chitietchi')->where('phieuchi_id', $order->id)
                            ->join('hoadonnhap', 'chitietchi.hoadonnhap_id', '=', 'hoadonnhap.id')
                            ->join('chitietnhap', 'chitietnhap.hoadonnhap_id', '=', 'hoadonnhap.id')
                            ->select('chitietchi.sotienchi', 'chitietchi.hoadonnhap_id', DB::raw('sum(chitietnhap.soluong*chitietnhap.gianhap) AS total_sales'))
                            ->groupBy('chitietchi.sotienchi', 'chitietchi.hoadonnhap_id')
                            ->get();
                    $arrPay[$order->id] = $orderDetails;
                }
                $count = count($listPay);
                if($count > 0){
                    $pay = true;
                }
                return view('web-bansua-admin.deposit-pay.danhsachthuchi', ['listDeposit' => $listDeposit, 'arrDeposit' => $arrDeposit, 'arrOption' => $arrOption, 'listPay' => $listPay, 'arrPay' => $arrPay, 'pay' => $pay, 'deposit' => $deposit]);
            }
        }
    }


    // thong ke cong no

    public function statisticIndex(){

        $list = DB::table('hoadonxuat')->join('chitietxuat', 'chitietxuat.hoadonxuat_id', '=', 'hoadonxuat.id')
                                ->join('chitietthu', 'chitietthu.hoadonxuat_id', '=', 'hoadonxuat.id')
                                ->join('users', 'hoadonxuat.khachhang_id', '=', 'users.id')
                                ->join('nhanvien', 'hoadonxuat.nguoigiaohang', '=', 'nhanvien.manv')
                                ->select('hoadonxuat.id', 'users.ten as tenkh', 'nhanvien.ten as tennv', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban)/count(chitietthu.id)*count(distinct(chitietxuat.id)) AS total_sales'), DB::raw('sum(chitietthu.sotienthu)/count(chitietxuat.id)*count(distinct(chitietthu.id)) AS total_deposit'))
                                ->groupBy('hoadonxuat.id', 'users.ten', 'nhanvien.ten', 'hoadonxuat.phiship')
                                ->havingRaw('sum(chitietxuat.soluong*chitietxuat.giaban)/count(chitietthu.id)*count(distinct(chitietxuat.id)) > sum(chitietthu.sotienthu)/count(chitietxuat.id)*count(distinct(chitietthu.id))')
                                ->get();

        return view('web-bansua-admin.statistics-report.thongkecongno', ['list' => $list]);
     }


    
}
