<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class HoaDonXuat extends Model
{
    protected $table = 'hoadonxuat';
    protected $fillable = [
		'id', 'khachhang_id', 'diachigiaohang','phuongthucthanhtoan', 'thanhtoan', 'phiship', 'trangthai', 'updated_at', 'created_at', 'nguoixuatkho', 'nguoigiaohang', 'note', 'ngaygiaohang',
	];

	public function listOrderWaitProcess(){
		$orders = DB::table('hoadonxuat')->where('trangthai', 'Chờ xử lý')
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')

                ->select('users.ten as tenkh', 'users.sdt', 'users.email','hoadonxuat.id', 'hoadonxuat.ngaygiaohang','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('hoadonxuat.id', 'users.ten', 'users.sdt', 'users.email', 'hoadonxuat.ngaygiaohang','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note')
                ->get();

        return $orders;
	}

	public function getOrderDetail($orderId){
		$orderDetails = DB::table('chitietxuat')->where('hoadonxuat_id', $orderId)
                	->join('sanpham', 'chitietxuat.sanpham_id', '=', 'sanpham.id')
                	->select('chitietxuat.*', 'sanpham.ten as name')
                	->get();
        return $orderDetails;
	}

	public function updateCustomer($orderId, $address, $time1, $time2){
		$update = DB::table('hoadonxuat')->where('id', $orderId)->update(['diachigiaohang'=>$address, 'ngaygiaohang'=>$time1."/".$time2]);
		return $update;
	}

	public function listOrderConfirmed(){
		$orders = DB::table('hoadonxuat')->where('hoadonxuat.trangthai', 'Đồng ý giao hàng')
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                
                ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                ->get();

        return $orders;
	}

	public function listOrderNotDivision(){
		$orders = DB::table('hoadonxuat')->where('trangthai', "Đồng ý giao hàng")
                            ->whereNull('nguoigiaohang')
                            ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                            ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            
                            ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                            ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                            ->get();

        return $orders;
	}

	public function listOrderDivision(){
		$orders = DB::table('hoadonxuat')->where('trangthai', "Đồng ý giao hàng")
                            ->whereNotNull('nguoigiaohang')
                            ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                            ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')

                            ->select('nhanvien.ten as nguoigiaohang','users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                            ->groupBy('nhanvien.ten','hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                            ->get();

        return $orders;
	}

	public function listOrderExport(){
		$orders = DB::table('hoadonxuat')->where('trangthai', "Đã xuất kho")
                ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')

                ->select('nhanvien.ten as gh','users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                ->groupBy('nhanvien.ten','hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                ->get();

        return $orders;
	}

	public function searchOrderById($orderId){
		$orders = DB::table('hoadonxuat')->where('hoadonxuat.id', $orderId)
                    ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')

                    ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                    ->get();

        return $orders;
	}

	public function searchOrder($id){
		$orders = DB::table('hoadonxuat')->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->whereIn('trangthai', ["Hủy","Thành công", "Trả lại", "Giao hàng không thành công"])
                    ->where(function ($query) use ($id) {
                            $query->where('hoadonxuat.id', 'LIKE', '%'.$id.'%')
                                ->orwhere('users.ten', 'LIKE', '%'.$id.'%');
                        })
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->select('users.ten as tenkh', 'hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.nguoigiaohang', 'hoadonxuat.phiship')
                    ->take(10)
                    ->get();

        return $orders;
	}

	public function search_autocomplete($query){
		$search = DB::table('hoadonxuat')->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->where('hoadonxuat.id', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.ten', 'LIKE', '%'.$query.'%')
                    ->select('hoadonxuat.*', 'users.ten as tenkh')
                    ->orderBy('id', 'asc')
                    ->take(6)
                    ->get();

        return $search;
	}

	public function search($product_id){
		$orders = DB::table('hoadonxuat')->where('hoadonxuat.id', $product_id)
                    ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->select('users.ten as tenkh','hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                    ->get();
        return $orders;
	}

	public function searchRandom($id){
		$orders =  DB::table('hoadonxuat')->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                    ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->where('hoadonxuat.id', 'LIKE', '%'.$id.'%')
                    ->orwhere('users.ten', 'LIKE', '%'.$id.'%')
                    ->select('users.ten as tenkh','hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))
                    ->groupBy('hoadonxuat.id', 'users.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship')
                    ->take(10)
                    ->get(); 
        return $orders;
	}
}
