<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\NhanVien;
use App\PhanQuyen;
use App\ChiTietNhap;
use App\ChiTietXuat;
use PDF;
use App\HoaDonNhap;

class ExportController extends Controller
{

    public function index(){

        $orders = null;
        $name = null;
        $arr = array();

        $giaohang = DB::table('phanquyen')
                    ->where('quyen_id', "quyen-17")
                    ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                    ->select('nhanvien.*')->get();
   		return view('web-bansua-admin.import-export.xuathangtudong', ['orders' => $orders, 'giaohang' => $giaohang, 'name' => $name, 'arr' => $arr]);
    }

    public function searchOrder(){
        $selected = $_GET['option_selected'];
        if($selected === 'Chọn người giao hàng'){
           
        }
        else{
        	$id = explode(' - ', $selected);
            $orders = DB::table('hoadonxuat')->where('trangthai', "Đồng ý giao hàng")
                    ->where('nguoigiaohang', $id[1])
                    ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')

                    ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                    ->get();
            
            $giaohang = DB::table('phanquyen')
                        ->where('quyen_id', "quyen-17")
                        ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                        ->select('nhanvien.*')->get();
            $name = NhanVien::where('manv', $id[1])->value('ten');
            $arr = array();
            $arrAuto = array();

            $stt = 1;
            $STT = 1;

	        foreach ($orders as $order) {

                $arrayExport = array();
	        	$orderDetails = DB::table('chitietxuat')->where('hoadonxuat_id', $order->id)
	                	->join('sanpham', 'chitietxuat.sanpham_id', '=', 'sanpham.id')
	                	->select('chitietxuat.*', 'sanpham.ten as name')
	                	->get();
	            $arr[$stt++] = $orderDetails;

                foreach ($orderDetails as $value) {
                    $product_id = $value->sanpham_id;
                    $product_number = $value->soluong;
                    $hansudung = DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $product_id)
                        ->select('chitietnhap.hansudung', DB::raw('SUM(chitietnhap.soluong) as total_number'))
                        ->groupBy('chitietnhap.hansudung')
                        ->havingRaw('SUM(chitietnhap.soluong) > 0')
                        ->orderBy('chitietnhap.hansudung', 'asc')
                        ->get();

                    foreach ($hansudung as $val) {
                        $hsd = $val->hansudung;
                        $count_export = DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $product_id)
                                ->where('chitietxuat.hansudung', $hsd)
                                ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                                ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                                ->sum('chitietxuat.soluong');
                        if($val->total_number > $count_export){
                            $avail = $val->total_number - $count_export;
                            if($product_number <= $avail){
                                array_push($arrayExport, array("id"=>$product_id,"name"=>$value->name,"number"=>$product_number, "hansudung" => $hsd));
                                break;
                            }
                            else{
                                array_push($arrayExport, array("id"=>$product_id,"name"=>$value->name,"number"=>$avail, "hansudung" => $hsd));
                                $product_number = $product_number - $avail;
                                
                            }
                        }
                        
                    }
                }

                $arrAuto[$STT++] =  $arrayExport;
	        }


            return view('web-bansua-admin.import-export.xuathangtudong', ['orders' => $orders, 'giaohang' => $giaohang, 'name' => $name, 'arr' => $arr, 'arrAuto' => $arrAuto]);
        }
                
           
        return redirect()->back();
    }


    public function saveExport(Request $request){
        $user_id = Session::get('admin')->manv;
        $key = $request->key_save;

        if(strpos($key, " ++ ") !== false){
            $list = explode(' ++ ', $key);

            $listCount = count($list);
            $order_id = $list[$listCount-1];
            $orderDetails = ChiTietXuat::where('hoadonxuat_id', $order_id)->get();

            $flag = array();

            for($i = 0; $i < $listCount-1; $i = $i+4){
                $product_id = (int)$list[$i];
                foreach ($orderDetails as $value) {
                    
                    if($product_id === $value->sanpham_id){
                        $list_date = explode('/', $list[$i+3]);
                        $date = $list_date[2].'-'.$list_date[1].'-'.$list_date[0];

                        if ((int)$list[$i+2] === $value->soluong){
                            $item = ChiTietXuat::where('hoadonxuat_id', $order_id)->where('sanpham_id', $value->sanpham_id)->update(['hansudung' => $date]);
                            
                        }
                        else{

                            if(in_array($product_id, $flag)){
                                $item = new ChiTietXuat([
                                    'soluong' => (int)$list[$i+2],
                                    'giaban' => $value->giaban,
                                    'hoadonxuat_id' => $order_id,
                                    'sanpham_id' => $product_id,
                                    'hansudung' => $date,
                                ]);
                                $item->save();
                            }
                            else{
                                array_push($flag, $product_id);
                                $item = ChiTietXuat::where('hoadonxuat_id', $order_id)->where('sanpham_id', $value->sanpham_id)->update(['soluong' => (int)$list[$i+2], 'hansudung' => $date]);
                            }
                            
                        }
                    }
                    
                }

            }
                
            $update = DB::table('hoadonxuat')->where('hoadonxuat.id', $order_id)->update(['hoadonxuat.trangthai' => 'Đã xuất kho', 'nguoixuatkho' => $user_id]);
            

            return Response('Lưu thành công');
        }
        
    }

    public function getInfo(Request $request){
        if($request->ajax()){
            $key = $request->key_get;
            if(strpos($key, "SP - ") !== false){
                $list = explode(' - ', $key);
                $p = DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $list[1])->get();
                $count_avaiable = DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $list[1])
                        ->select('chitietnhap.hansudung', DB::raw('SUM(chitietnhap.soluong) as total_number'))
                        ->groupBy('chitietnhap.hansudung')
                        ->havingRaw('SUM(chitietnhap.soluong) > 0')
                        ->orderBy('chitietnhap.hansudung', 'asc')
                        ->get();

                $out = null;
                $i = 0;
                $arr = array();
                foreach ($count_avaiable as $value) {
                    $hsd = $value->hansudung;
                    $count_export = DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $list[1])
                            ->where('chitietxuat.hansudung', $hsd)
                            ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                            ->sum('chitietxuat.soluong');
                    if($value->total_number > $count_export){
                        ++$i;
                        if($i === 1){
                            array_push($arr, $value->total_number - $count_export);
                        }
                        $out.='<option>'.date('d-m-Y', strtotime($value->hansudung)).'</option>';
                    }
                    
                }
                if($out === null){
                    return Response('Hết hàng');
                }
                else{
                    array_push($arr, $out);
                    return Response($arr);
                }
            }
            
        }
    }


    public function getNumberProduct(Request $request){
        if($request->ajax()){
            $key = $request->key;
            if(strpos($key, " ++ ") !== false){

                $list = explode(' ++ ', $key);
                $product_id = explode(' - ', $list[1]);
                $id = $product_id[1];
                $list_date = explode('-', $list[0]);
                $date = $list_date[2].'-'.$list_date[1].'-'.$list_date[0];

                $count = DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $id)
                        ->whereDate('chitietnhap.hansudung', $date)
                        ->sum('chitietnhap.soluong');
                $count_export = DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $id)
                            ->whereDate('chitietxuat.hansudung', $date)
                            ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                            ->sum('chitietxuat.soluong');

                return Response($count - $count_export);
            }
            
        }
    }

    // public function saveExport(Request $request){
    //     if($request->ajax()){
    //         $user_id = Session::get('admin')->manv;
    //         $key = $request->key_save;
    //         if(strpos($key, " ++ ") !== false){
    //             $list = explode(' ++ ', $key);

    //             $listCount = count($list);
    //             $order_id = $list[$listCount-1];
    //             $orderDetails = ChiTietXuat::where('hoadonxuat_id', $order_id)->get();
                
    //             $check = false;
    //             $checkComplete = false;
    //             $flag = array();

    //             for($i = 0; $i < $listCount-1; $i = $i+4){
                       
    //                 foreach ($orderDetails as $value) {

    //                     $product_id = (int)$list[$i];
                        
    //                     if($product_id === $value->sanpham_id){
    //                         $check = true;
                            
    //                         if ((int)$list[$i+2] > $value->soluong){
    //                             return Response('Số lượng sản phẩm có mã '. $value->sanpham_id.' nhiều hơn số lượng khách đặt');
    //                         }
    //                         else if ((int)$list[$i+2] === $value->soluong){
    //                             $list_date = explode('-', $list[$i+3]);
    //                             $date = $list_date[2].'-'.$list_date[1].'-'.$list_date[0];
    //                             $item = ChiTietXuat::where('hoadonxuat_id', $order_id)->where('sanpham_id', $value->sanpham_id)->update(['soluong' => (int)$list[$i+2], 'hansudung' => $date]);
    //                             $checkComplete = true;
    //                         }
    //                         else{
    //                             $list_date = explode('-', $list[$i+3]);
    //                             $date = $list_date[2].'-'.$list_date[1].'-'.$list_date[0];

    //                             if(in_array($product_id, $flag)){
    //                                 $item = new ChiTietXuat([
    //                                     'soluong' => (int)$list[$i+2],
    //                                     'giaban' => $value->giaban,
    //                                     'hoadonxuat_id' => $order_id,
    //                                     'sanpham_id' => $product_id,
    //                                     'hansudung' => $date,
    //                                 ]);
    //                                 $item->save();
    //                             }
    //                             else{
    //                                 array_push($flag, $product_id);
    //                                 $item = ChiTietXuat::where('hoadonxuat_id', $order_id)->where('sanpham_id', $value->sanpham_id)->update(['soluong' => (int)$list[$i+2], 'hansudung' => $date]);
    //                             }
    //                             $checkComplete = true;
                                
    //                         }
    //                     }
    //                 }

    //                 if($check === false){
    //                     return Response('Không có sản phẩm có mã '.$product_id.' trong đơn đặt hàng');
    //                 }
    //             }
    //             if($checkComplete){
    //                 $update = DB::table('hoadonxuat')->where('hoadonxuat.id', $order_id)->update(['hoadonxuat.trangthai' => 'Đã xuất kho', 'nguoixuatkho' => $user_id]);
    //             }

    //             return Response('Lưu thành công');
    //         }
    //     }
    // }


    public function getPDF($id){
       $orders = DB::table('hoadonxuat')->where('hoadonxuat.id', $id)
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')

                ->select('users.ten as tenkh', 'users.sdt', 'users.email','hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('hoadonxuat.id', 'users.ten', 'users.sdt', 'users.email', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note')
                ->get();

        $orderDetails = DB::table('chitietxuat')->where('hoadonxuat_id', $id)
                ->join('sanpham', 'chitietxuat.sanpham_id', '=', 'sanpham.id')
                ->select('chitietxuat.sanpham_id', 'chitietxuat.giaban', 'sanpham.ten as name', DB::raw('sum(chitietxuat.soluong) AS total_number'))
                ->groupBy('chitietxuat.sanpham_id', 'sanpham.ten', 'chitietxuat.giaban')
                ->get();

        $pdf = PDF::loadView('web-bansua-admin.import-export.export_bill', [ 'orders' => $orders, 'orderDetails' => $orderDetails]);

        return $pdf->stream('export_order.pdf');
    }


}
