<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SanPham;
use App\HoaDonNhap;
use App\ChiTietXuat;
use App\ChiTietNhap;
use App\HoaDonXuat;
use Session;
use App\Cart;
use App\GioHang;
use App\User;
use Illuminate\Support\Facades\Input;
use File;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use PDF;

class ImportController extends Controller
{
    public function import(){
    	$list_provider=DB::table('nhacungcap')->select('id', 'ten')->get();
    	$list_product=DB::table('sanpham')->select('id','ten')->get();
       return view('web-bansua-admin.import-export.import', ['listProvider' => $list_provider, 'listProduct' => $list_product]);
    }
    public function addImport(Request $request){
   
       if($request->ajax()){
       	$manv="nv-0002";
       	$datas = $request->key;
       	$provier_id=$request->id;       
        $item = new HoaDonNhap([ 'manv' => $manv,
                                'nhacungcap_id' => $provier_id,
                                    ]);
         $item->save();
         $id=DB::getPdo()->lastInsertId();
        
         $countColumn = 0;
        foreach( $datas as $data){
         $countColumn += count( $data);
          }
          $countRow=count($datas);
         for($i=1;$i<=$countRow;$i++){
                $money = $datas[$i][2];
                $listmoney = explode(",", $money);
                $money_import = '';
                foreach ($listmoney as $value) {
                    $money_import .= $value;
                }
                
                $item=new ChiTietNhap([ 'soluong' => $datas[$i][3],
                                         'gianhap' => $money_import,
                                         'hoadonnhap_id' =>$id,
                                         'sanpham_id' =>$datas[$i][0],
                                         'hansudung' =>$datas[$i][4],
                                       ]);
                 $item->save();
             
             }

         return Response("Nhập hàng thành công");   
      
    }
}
    

    public function getPDF(){
       $maxId = DB::table('hoadonnhap')->max('id');
       $orders = DB::table('hoadonnhap')->where('hoadonnhap.id', $maxId)
                ->join('nhacungcap', 'nhacungcap.id', '=', 'hoadonnhap.nhacungcap_id')
                ->join('chitietnhap', 'hoadonnhap.id', '=', 'chitietnhap.hoadonnhap_id')

                ->select('nhacungcap.ten', 'nhacungcap.sdt', 'nhacungcap.diachi','hoadonnhap.id', DB::raw('sum(chitietnhap.soluong*chitietnhap.gianhap) AS total_import'))

                ->groupBy('nhacungcap.ten', 'nhacungcap.sdt', 'nhacungcap.diachi','hoadonnhap.id')
                ->get();

        $orderDetails = DB::table('chitietnhap')->where('hoadonnhap_id', $maxId)
                ->join('sanpham', 'chitietnhap.sanpham_id', '=', 'sanpham.id')
                ->select('chitietnhap.*', 'sanpham.ten as name')
                ->get();

        $pdf = PDF::loadView('web-bansua-admin.import-export.import_bill', [ 'orders' => $orders, 'orderDetails' => $orderDetails]);

        return $pdf->stream('import_order.pdf');
    }

    public function getImportPDF($id){
       $orders = DB::table('hoadonnhap')->where('hoadonnhap.id', $id)
                ->join('nhacungcap', 'nhacungcap.id', '=', 'hoadonnhap.nhacungcap_id')
                ->join('chitietnhap', 'hoadonnhap.id', '=', 'chitietnhap.hoadonnhap_id')

                ->select('nhacungcap.ten', 'nhacungcap.sdt', 'nhacungcap.diachi','hoadonnhap.id', DB::raw('sum(chitietnhap.soluong*chitietnhap.gianhap) AS total_import'))

                ->groupBy('nhacungcap.ten', 'nhacungcap.sdt', 'nhacungcap.diachi','hoadonnhap.id')
                ->get();

        $orderDetails = DB::table('chitietnhap')->where('hoadonnhap_id', $id)
                ->join('sanpham', 'chitietnhap.sanpham_id', '=', 'sanpham.id')
                ->select('chitietnhap.*', 'sanpham.ten as name')
                ->get();

        $pdf = PDF::loadView('web-bansua-admin.import-export.import_bill', [ 'orders' => $orders, 'orderDetails' => $orderDetails]);

        return $pdf->stream('import_order.pdf');
    }

     public function importReturn(Request $request){
        return view('web-bansua-admin.import-export.import_return');

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
                $data[]=array('value'=>'Mã đơn hàng - '.$order->id.' - '.$order->tenkh);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }
    public function search_export_by_key(Request $request){
       if(Session::has('dataExportBill')){
            $request->session()->forget('dataExportBill');
            $request->session()->forget('dataDetailExport');
            $request->session()->forget('nameKH');

       }
    

        $id = $_GET['search_export'];
         if($id !== ''){
                if(strpos($id, "Mã đơn hàng - ") !== false){
                    $a = explode(' - ', $id);
                    $name=$a[2];
                    $dataExportBill=DB::table('hoadonxuat')->where('id', $a[1])
                                ->join('nhanvien', 'nhanvien.manv', '=', 'hoadonxuat.nguoigiaohang')
                                ->select('hoadonxuat.*', 'nhanvien.ten as tennv')  ->get(); 

                     $dataDetailExport= DB::table('chitietxuat')->where('chitietxuat.hoadonxuat_id', $a[1])
                    ->join('sanpham', 'sanpham.id', '=', 'chitietxuat.sanpham_id')                   
                    ->select('chitietxuat.*', 'sanpham.ten as ten')
                    ->get();
                 }
             }

        if((!empty($dataExportBill))&&(!empty($dataDetailExport))){
              
            $request->session()->put('dataExportBill', $dataExportBill);
            $request->session()->put('dataDetailExport', $dataDetailExport);
            $request->session()->put('nameKH', $name);

        
    }

        return redirect()->back();

    }
    public function submitReturnExport(Request $request){
         $id = $request->input('input_id_bill');
         $hinhthuc= $request->input('option_export');  

         DB::table('hoadonxuat')
            ->where('id', $id)
            ->update(['trangthai'=> $hinhthuc]);
            return  redirect()->back();
    }

    public function listIndex(){
        $arrOption = ['Hóa đơn nhập', 'Hóa đơn xuất'];
        $listExport = null;
        $arrExport = null;
        $listImport = null;
        $arrImport = null;
        $import = false;
        $export = false;
        return view('web-bansua-admin.import-export.danhsachnhapxuat', ['listExport' => $listExport, 'arrExport' => $arrExport, 'arrOption' => $arrOption, 'listImport' => $listImport, 'arrImport' => $arrImport, 'import' => $import, 'export' => $export]);
    }

    public function searchOrderImportExport(){
        if(isset($_GET['searchOrder'])){
            $option = $_GET['option_selected'];
            $query = $_GET['search_order'];
            $listExport = null;
            $arrExport = array();
            $listImport = null;
            $arrImport = array();
            $import = false;
            $export = false;

            if($option == 'Hóa đơn nhập'){
                $arrOption = ['Hóa đơn nhập', 'Hóa đơn xuất'];
                $listImport = DB::table('hoadonnhap')->where('hoadonnhap.id', $query)
                        ->join('nhacungcap', 'nhacungcap.id', '=', 'hoadonnhap.nhacungcap_id')
                        ->join('chitietnhap', 'hoadonnhap.id', '=', 'chitietnhap.hoadonnhap_id')
                        
                        ->select('nhacungcap.ten as ten', 'hoadonnhap.id','hoadonnhap.created_at', DB::raw('sum(chitietnhap.soluong*chitietnhap.gianhap) AS total_sales'))

                        ->groupBy('nhacungcap.ten', 'hoadonnhap.id','hoadonnhap.created_at')
                        ->get();

                
                foreach ($listImport as $order) {
                    $orderDetails = DB::table('chitietnhap')->where('hoadonnhap_id', $order->id)
                            ->join('sanpham', 'chitietnhap.sanpham_id', '=', 'sanpham.id')
                            ->select('chitietnhap.*', 'sanpham.ten as name')
                            ->get();
                    $arrImport[$order->id] = $orderDetails;
                }
                $count = count($listImport);
                if($count > 0){
                    $import = true;
                }
                
                return view('web-bansua-admin.import-export.danhsachnhapxuat', ['listExport' => $listExport, 'arrExport' => $arrExport, 'arrOption' => $arrOption, 'listImport' => $listImport, 'arrImport' => $arrImport, 'import' => $import, 'export' => $export]);

            }
            else if($option == 'Hóa đơn xuất'){
                $arrOption = ['Hóa đơn xuất', 'Hóa đơn nhập'];
                $listExport = DB::table('hoadonxuat')->where('hoadonxuat.id', $query)
                        ->whereIn('trangthai', ["Hủy","Thành công", "Trả lại", "Giao hàng không thành công", "Đã xuất kho"])
                        ->join('users', 'users.id', '=', 'hoadonxuat.khachhang_id')
                        ->join('chitietxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                        ->join('nhanvien', 'hoadonxuat.nguoigiaohang', '=', 'nhanvien.manv')

                        ->select('users.ten as tenkh', 'users.sdt', 'users.email', 'nhanvien.ten as giaohang','hoadonxuat.id','hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note', DB::raw('sum(chitietxuat.soluong*chitietxuat.giaban) AS total_sales'))

                        ->groupBy('hoadonxuat.id', 'users.ten', 'users.sdt', 'users.email','nhanvien.ten', 'hoadonxuat.created_at', 'hoadonxuat.trangthai', 'hoadonxuat.phuongthucthanhtoan', 'hoadonxuat.diachigiaohang', 'hoadonxuat.phiship', 'hoadonxuat.note')
                        ->get();
                
                
                foreach ($listExport as $order) {
                    $orderDetails = DB::table('chitietxuat')->where('hoadonxuat_id', $order->id)
                            ->join('sanpham', 'chitietxuat.sanpham_id', '=', 'sanpham.id')
                            ->select('chitietxuat.*', 'sanpham.ten as name')
                            ->get();
                    $arrExport[$order->id] = $orderDetails;
                }
                $count = count($listExport);
                if($count > 0){
                    $export = true;
                }
                
                return view('web-bansua-admin.import-export.danhsachnhapxuat', ['listExport' => $listExport, 'arrExport' => $arrExport, 'arrOption' => $arrOption, 'listImport' => $listImport, 'arrImport' => $arrImport, 'import' => $import, 'export' => $export]);
            }
        }


    }

}

