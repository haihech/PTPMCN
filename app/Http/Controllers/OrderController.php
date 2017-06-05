<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\HoaDonXuat;
use App\ChiTietXuat;
use App\PhanDonHang;
use App\PhanQuyen;
use Session;
use App\NhanVien;
use DB;

class OrderController extends Controller
{

    public function waitProcess(Request $request){

        $hd = new HoaDonXuat();
        $orders = $hd->listOrderWaitProcess();

        $arr = array();
        $i = 0;
        
        foreach ($orders as $order) {
            
            $orderDetails = $hd->getOrderDetail($order->id);       
            $arr[$i] = $orderDetails;
            $i++;
        }
        return view('web-bansua-admin.order.choxuly', ['orders' => $orders, 'arr' => $arr,'i' => $i]);
    }

    public function updateCustomer(Request $request){
        if($request->ajax()){
            $data = $request->key;
            $list = explode("---", $data);

            $order = new HoaDonXuat();
            $update = $order->updateCustomer($list[3], $list[0], $list[1], $list[2]);
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

        $hd = new HoaDonXuat();
        $orders = $hd->listOrderConfirmed();
        $i = count($orders);

        $pq = new PhanQuyen();
        $giaohang = $pq->getShipper();
        $arr = array('Tất cả', 'Chưa phân công giao hàng', 'Đã phân công giao hàng' );
        return view('web-bansua-admin.order.dongygiaohang', ['orders' => $orders, 'giaohang' => $giaohang,'i' => $i, 'arr' => $arr]);
    }

    public function search_confirmed(){
        if(isset($_GET['timkiemxacnhan'])){
            if(!empty($_GET['option_selected1'])){
                $selected = $_GET['option_selected1'];
                $hd = new HoaDonXuat();
                $pq = new PhanQuyen();
                $giaohang = $pq->getShipper();
                if($selected === 'Tất cả'){
                    return $this->confirmed();
                    
                }
                else if($selected === 'Chưa phân công giao hàng'){
                    $orders = $hd->listOrderNotDivision();
                    $i = count($orders);
                    $arr = array('Chưa phân công giao hàng', 'Tất cả', 'Đã phân công giao hàng' );
                    return view('web-bansua-admin.order.dongygiaohang', ['orders' => $orders, 'giaohang' => $giaohang,'i' => $i, 'arr' => $arr]);
                }

                else if($selected === 'Đã phân công giao hàng'){
                    
                    $orders = $hd->listOrderDivision();
                    $i = count($orders);
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

        $hd = new HoaDonXuat();
        $orders = $hd->listOrderExport();
        $i = count($orders);
     
        return view('web-bansua-admin.order.xuatkhoguikhachhang', ['orders' => $orders, 'i' => $i]);
    }

    public function comleted(Request $request){

        return view('web-bansua-admin.order.hoanthanh');
    }


    public function search_comleted_order(Request $request){

        $id = $request->search_comleted_order;
        $hd = new HoaDonXuat();
        if(strpos($id, 'Mã đơn hàng -- ') !== false){
            $a = explode(' -- ', $id);
            $orders = $hd->searchOrderById($a[1]);
        }
        else{
            $orders = $hd->searchOrder($id);

        }
        if(!empty($orders)){
            $request->session()->forget('orders');

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
        
        $hd = new HoaDonXuat();
        $search = $hd->search_autocomplete($query);
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
        
        $hd = new HoaDonXuat();
        $orders = $hd->search_autocomplete($query);
        
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

        $hd = new HoaDonXuat();

        $id = $request->input('search_order');
        if(strpos($id, "Mã đơn hàng -- ") !== false){
            $a = explode(' -- ', $id);
            $orders = $hd->search($a[1]);
        }
        else{
            $orders = $hd->searchRandom($id);

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

