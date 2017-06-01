<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\HoaDonXuat;
use App\ChiTietXuat;
use App\PhanDonHang;
use Session;
use App\NhanVien;
use DB;

class OrderController extends Controller
{

    public function waitProcess(Request $request){
        
        $orders = DB::table('hoadonxuat')->where('trangthai', 'Chờ xử lý')
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')

                ->select('users.ten as tenkh', 'users.sdt', 'users.email','hoadonxuat.id', 'hoadonxuat.ngaygiaohang','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('hoadonxuat.id', 'users.ten', 'users.sdt', 'users.email', 'hoadonxuat.ngaygiaohang','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note')
                ->get();
        
        $arr = array();
        $i = 0;
        
        foreach ($orders as $order) {
            ++$i;
        	$orderDetails = DB::table('chitietxuat')->where('hoadonxuat_id', $order->id)
                	->join('sanpham', 'chitietxuat.sanpham_id', '=', 'sanpham.id')
                	->select('chitietxuat.*', 'sanpham.ten as name')
                	->get();
            $arr[$order->id] = $orderDetails;
        }
    	return view('web-bansua-admin.order.choxuly', ['orders' => $orders, 'arr' => $arr,'i' => $i]);
    }

    public function updateCustomer(Request $request){
        if($request->ajax()){
            $data = $request->key;
            $list = explode("---", $data);

            $update = DB::table('hoadonxuat')->where('id', $list[3])->update(['diachigiaohang'=>$list[0], 'ngaygiaohang'=>$list[1]."/".$list[2]]);
            if($update){
                return Response("Cập nhật thành công");
            }
        }
    }

    public function confirmOrder(Request $request, $id){
    	$order = HoaDonXuat::where('id', $id)->update(['trangthai' => 'Đồng ý giao hàng']);
        return redirect()->route('choxuly');
    }

    public function cancelOrder(Request $request, $id){
    	$order = HoaDonXuat::where('id', $id)->update(['trangthai' => 'Hủy']);
        return redirect()->route('choxuly');
    }


    public function confirmed(){

        $orders = DB::table('hoadonxuat')->where('hoadonxuat.trangthai', 'Đồng ý giao hàng')
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                
                ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                ->get();
        $i = count($orders);

        $giaohang = DB::table('phanquyen')
                    ->where('quyen_id', "quyen-17")
                    ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                    ->select('nhanvien.*')->get();
        $arr = array('Tất cả', 'Chưa phân công giao hàng', 'Đã phân công giao hàng' );
        return view('web-bansua-admin.order.dongygiaohang', ['orders' => $orders, 'giaohang' => $giaohang,'i' => $i, 'arr' => $arr]);
    }

    public function search_confirmed(){
        if(isset($_GET['timkiemxacnhan'])){
            if(!empty($_GET['option_selected1'])){
                $selected = $_GET['option_selected1'];
                if($selected === 'Tất cả'){
                    return $this->confirmed();
                    
                }
                else if($selected === 'Chưa phân công giao hàng'){
                    $orders = DB::table('hoadonxuat')->where('trangthai', "Đồng ý giao hàng")
                            ->whereNull('nguoigiaohang')
                            ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                            ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            
                            ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                            ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                            ->get();
                    $i = count($orders);

                    $giaohang = DB::table('phanquyen')
                                ->where('quyen_id', "quyen-17")
                                ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                                ->select('nhanvien.*')->get();

                    $arr = array('Chưa phân công giao hàng', 'Tất cả', 'Đã phân công giao hàng' );
                    return view('web-bansua-admin.order.dongygiaohang', ['orders' => $orders, 'giaohang' => $giaohang,'i' => $i, 'arr' => $arr]);
                }

                else if($selected === 'Đã phân công giao hàng'){
                    $orders = DB::table('hoadonxuat')->where('trangthai', "Đồng ý giao hàng")
                            ->whereNotNull('nguoigiaohang')
                            ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                            ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')

                            ->select('nhanvien.ten as nguoigiaohang','users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                            ->groupBy('nhanvien.ten','hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                            ->get();
                    $i = count($orders);
                    $giaohang = DB::table('phanquyen')
                                ->where('quyen_id', "quyen-17")
                                ->join('nhanvien', 'nhanvien.manv', '=', 'phanquyen.nhanvien_manv')
                                ->select('nhanvien.*')->get();

                    $arr = array( 'Đã phân công giao hàng', 'Tất cả', 'Chưa phân công giao hàng' );
                    return view('web-bansua-admin.order.dongygiaohang', ['orders' => $orders, 'giaohang' => $giaohang,'i' => $i, 'arr' => $arr]);
                }
            }
        }
        return redirect()->back();
    }

    public function division(Request $request){
        if(isset($_GET['phancong'])){
            if(!empty($_GET['donhang'])){
                if(!empty($_GET['option_selected'])){
                    $gh = $_GET['option_selected'];
                    $id = explode(' - ', $gh);
                    foreach ($_GET['donhang'] as $order) {

                        $update = HoaDonXuat::where('id', $order)->update(['nguoigiaohang' => $id[1]]);
                    }   
                }
                else{
                    echo "Bạn chưa chọn người giao hàng";
                }
            }
            else{
                echo 'Bạn phải chọn ít nhất 1 đơn hàng';
            }
        }
        return redirect()->back();
    }

    public function exported(Request $request){

        $orders = DB::table('hoadonxuat')->where('trangthai', "Đã xuất kho")
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')

                ->select('nhanvien.ten as gh','users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('nhanvien.ten','hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                ->get();
        $i = count($orders);
     
        return view('web-bansua-admin.order.xuatkhoguikhachhang', ['orders' => $orders, 'i' => $i]);
    }

    public function comleted(Request $request){

        return view('web-bansua-admin.order.hoanthanh');
    }


    public function search_comleted_order(Request $request){

        $id = $request->search;
        if(strpos($id, 'Mã đơn hàng -- ') !== false){
            $a = explode(' -- ', $id);
            $orders = HoaDonXuat::where('hoadonxuat.id', $a[1])
                    ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')

                    ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                    ->get();
        }
        else{
            $orders = DB::table('hoadonxuat')->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->whereIn('trangthai', ["Hủy","Thành công", "Trả lại", "Giao hàng không thành công"])
                    ->where(function ($query) use ($id) {
                            $query->where('hoadonxuat.id', 'LIKE', '%'.$id.'%')
                                ->orwhere('users.ten', 'LIKE', '%'.$id.'%');
                        })
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                    
                    ->get();

        }
        if(!empty($orders)){
            $request->session()->put('orders', $orders);
        }
        
        return redirect()->route('dahoanthanh');
    }

    
    public function updateStatusCompleted(Request $request){
        if(isset($_GET['capnhattrangthai'])){
            if(!empty($_GET['donhang'])){
                if(!empty($_GET['option_selected'])){
                    $status = $_GET['option_selected'];
                    foreach ($_GET['donhang'] as $order) {
                        $update = HoaDonXuat::where('id', $order)->update(['trangthai' => $status]);
                    }   
                }
                else{
                    echo "Bạn chưa chọn trạng thái đơn hàng";
                }
                
            }
            else{
                echo 'Bạn phải chọn ít nhất 1 đơn hàng';
            }
        }
        if(Session::has('orders')){
            $list = Session::get('orders');
            $a = array();
            foreach ($list as $value) {
                $id = $value->id;
                $x = HoaDonXuat::find($id);
                array_push($a, $x);
            }
            $request->session()->forget('orders');
            $request->session()->put('orders', $a);
        }
        return redirect()->back();
    }


    public function updateStatus(Request $request){
        if(isset($_GET['capnhattrangthai'])){
            if(!empty($_GET['donhang'])){
                if(!empty($_GET['option_selected'])){
                    $status = $_GET['option_selected'];
                    foreach ($_GET['donhang'] as $order) {
                        $update = HoaDonXuat::where('id', $order)->update(['trangthai' => $status]);
                    }   
                }
                else{
                    echo "Bạn chưa chọn trạng thái đơn hàng";
                }
                
            }
            else{
                echo 'Bạn phải chọn ít nhất 1 đơn hàng';
            }
        }
        return redirect()->back();
    }


    public function search_autocomplete(Request $request){
        $query = $request->get('term');
        
        $search = DB::table('hoadonxuat')->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->where('hoadonxuat.id', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.ten', 'LIKE', '%'.$query.'%')
                    ->select('hoadonxuat.*', 'users.ten as tenkh')
                    ->orderBy('id', 'asc')
                    ->take(8)
                    ->get();
        $orders = array();
            $status = array("Hủy","Thành công", "Trả lại", "Giao hàng không thành công");
            foreach ($search as $value) {
                foreach ($status as $k) {
                    if($value->trangthai === $k){
                        array_push($orders, $value);
                    }
                }
            }
        $data=array();
        foreach ($orders as $order) {
                $data[]=array('value'=>'Mã đơn hàng -- '.$order->id.' -- KH: '.$order->tenkh);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }

    public function autoComplete(Request $request) {
        $query = $request->get('term');
        
        $orders = HoaDonXuat::join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->where('hoadonxuat.id', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.ten', 'LIKE', '%'.$query.'%')
                    ->select('hoadonxuat.*', 'users.ten as tenkh')
                    ->orderBy('id', 'asc')
                    ->take(6)
                    ->get();
        
        $data=array();
        foreach ($orders as $order) {
                $data[]=array('value'=>'Mã đơn hàng -- '.$order->id.' -- KH: '.$order->tenkh);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }

    public function searchOrder(Request $request){
        if(Session::has('search_orders')){
            $request->session()->forget('search_orders');
        }

        $id = $request->input('search_order');
        if(strpos($id, "Mã đơn hàng -- ") !== false){
            $a = explode(' -- ', $id);
            $product_id =  $a[1];
            $orders = DB::table('hoadonxuat')->where('hoadonxuat.id', $product_id)
                    ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->select('users.ten as tenkh','hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                    ->get();
        }
        else{
            $orders = HoaDonXuat::join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->where('hoadonxuat.id', 'LIKE', '%'.$id.'%')
                    ->orwhere('users.ten', 'LIKE', '%'.$id.'%')
                    ->select('users.ten as tenkh','hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                    ->take(10)
                    ->get(); 

        }
        if(!empty($orders)){
            $request->session()->put('search_orders', $orders);
        }

        return redirect()->back();  
    }

    public function search(Request $request){
        return view('web-bansua-admin.order.timkiemdonhang');
    }

}
