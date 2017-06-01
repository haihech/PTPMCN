<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SanPham;
use Session;
use App\Cart;
use App\GioHang;
use Illuminate\Support\Facades\Input;
use File;
use App\NhomTuoi;
use App\ThuongHieu;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Carbon\Carbon;
use App\KhuyenMai;
use Auth;
use stdClass;


class ProductController extends Controller
{

    // WEb bán hàng

    public $sanpham;
        function __construct(){
            $this->sanpham=new SanPham();
        }
        public function getThuongHieu($id){
            $sql=new stdClass();
            $sql->thuonghieu=$id;
            $sql->th=ThuongHieu::find($id)->ten;
            $sql->nhomtuoi=-1;
            $sql->giamgia=-1;
            $sql->khuyenmai=-1;
            $sql->hot=-1;
            return $this->getAllProduct(0,$sql);
        }
        public function getNhomTuoi($id){
            $sql=new stdClass();
            $sql->thuonghieu=-1;
            $sql->nhomtuoi=$id;
            $sql->giamgia=-1;
            $sql->khuyenmai=-1;
            $sql->hot=-1;
            $sql->t=NhomTuoi::find($id)->tuoi;
            return $this->getAllProduct(0,$sql);
        }
        public function getKhuyenMai(){
            $sql=new stdClass();
            $sql->thuonghieu=-1;
            $sql->nhomtuoi=-1;
            $sql->hot=-1;
            $sql->giamgia=-1;
            $sql->khuyenmai=1;
            return $this->getAllProduct(0,$sql);
        }
        public function getHot(){
            $sql=new stdClass();
            $sql->thuonghieu=-1;
            $sql->nhomtuoi=-1;
            $sql->hot=1;
            $sql->giamgia=-1;
            $sql->khuyenmai=-1;
            return $this->getAllProduct(0,$sql);
        }
        public function getGiamGia(){
            $sql=new stdClass();
             $sql->thuonghieu=-1;
            $sql->nhomtuoi=-1;
            $sql->giamgia=1;
            $sql->khuyenmai=-1;
            $sql->hot=-1;
            return $this->getAllProduct(0,$sql);
        }
        public function getAllProduct($index=0,$sql=null){
            $thuongHieu=new ThuongHieu();
            $nhomTuoi=new NhomTuoi();
            if($sql==null){
                $sql = new stdClass();
                $sql->thuonghieu=-1;
                $sql->nhomtuoi=-1;
                $sql->giamgia=-1;
                $sql->khuyenmai=-1;
                $sql->hot=-1;
            }
            $data=[];
            $tuoi=$nhomTuoi->getAll();
            $thuongHieu= $thuongHieu->getAll();
            return view('client.home',['tuoi'=>$tuoi,'thuonghieu'=>$thuongHieu,'yeuthich'=>$data,'khuyenmai'=>$data,'sql'=>$sql]);
        }

        public function getMoreProducts($index,$nums,$thuonghieu=-1,$nhomtuoi=-1,$giamgia=-1)
        {
            $list=$this->sanpham->getSomeProducts($index,$nums,$thuonghieu,$nhomtuoi,$giamgia);
           
            foreach($list as $k=> $e){
                $e=$this->checkKhuyenMai($e);
            }
            $classN="eProduct";
            $show_cart='';
            return view('layouts.product',compact('list','classN','show_cart'));
        }
        public function checkKhuyenMai($sp){
            $n=(clone $sp);
            $sp->km=count($n->khuyenmai);
            return $sp;
        }
        
        public function productDetail($id){
            $thuongHieu=new ThuongHieu();
            $nhomTuoi=new NhomTuoi();
            $tuoi=$nhomTuoi->getAll();
            $thuongHieu= $thuongHieu->getAll();
            $sp = new SanPham();
            $a = $sp->getProduct($id);

            $count_export = \DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $id)
                    ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                    ->sum('chitietxuat.soluong');

            $count_avaiable = \DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $id)
                    ->sum('chitietnhap.soluong');
            $bool = false;
            if($count_export < $count_avaiable){
                $bool = true;
            }

            return view('client.product_detail', ['tuoi'=>$tuoi,'thuonghieu'=>$thuongHieu,'a' => $a, 'bool'=>$bool]);
        }  

         public function getCart(){
            return GioHang::where('khachhang_id',Auth::user()->id)->pluck('sanpham_id')->all();
        }
        public function getAddToCart($id,$sl){
            // Session::forget('cart');
            // return "Đặt hàng thành công!";
             $sp = new SanPham();
             $sanpham = $sp->getProduct($id);
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
                
            $cart->addSp($id, $sl);
             session()->put('cart', $cart);
         //   $cart->add($sanpham,$id, $sl);         
            if(Auth::user()){
                $list=$this->getCart();
                if(in_array($id, $list)){
                     $x=GioHang::where('sanpham_id',$id)->first();
                    $x->soluong+=$sl;
                    $x->save();
                }else{
                    $x=GioHang::create(['soluong' =>$sl ,
                   'khachhang_id' => Auth::user()->id,
                   'sanpham_id' => $id]);
                    $x->save();
                }
            }
            return "Đặt hàng thành công!";
        }

        public function search(Request $request){
            $name= $request->input('tensp');
            $list=SanPham::where('ten', 'LIKE', '%'.$name.'%')->get();
            $thuongHieu=new ThuongHieu();
            $nhomTuoi=new NhomTuoi();
            $tuoi=$nhomTuoi->getAll();
            $thuongHieu= $thuongHieu->getAll();

             $classN="eProduct";
            $view=view('layouts.product',compact('list','classN'))->with('show_cart','');
            return view('client.search',['tuoi'=>$tuoi,'thuonghieu'=>$thuongHieu,'view'=>$view,'nums'=>count($list)]);
        }

	// public function search(Request $request){
 //        if($request->ajax()){
 //            $search = SanPham::where('ten', 'LIKE', '%'.$request->search.'%')->get();
 //            if($search){
 //                $out = '';
 //                $out = '<ul class= "list-styled">';
 //                foreach ($search as $value) {
 //                    $out.='<li><a href="#">'.$value->ten.'</a></li>';
 //                }
 //                $out .='</ul>';
 //                return Response($out);
 //            }
 //        }
 //    }

 //    public function getNote(Request $request){
 //        if($request->ajax()){
 //            $search = SanPham::where('id', $request->motasp)->get();
 //            $out = '<ul  style="list-style-type: square;">';
 //            $out .= $search->mota;
 //            $out .='</ul>';
 //            return Response($out);
 //        }
 //    }

 //    public function searchProductByKey(Request $request){
 //        $key = $request->input('search');
 //        $products = SanPham::where('ten', 'LIKE', '%'.$key.'%')->get();
 //        return view('web-bansua.search', ['products' => $products, 'keySearch' => $key]);
 //    }
    
 //    public function getAllProduct(){
 //    	$sp = new SanPham();
 //    	$sanpham = $sp->getAllProduct();
 //    	return view('web-bansua.home',compact('sanpham'));
 //    }

 //    public function productDetail($id){
 //        $sp = new SanPham();
 //        $a = $sp->getProduct($id);
 //        return view('web-bansua.detail-product', compact('a'));
 //    }    

 //    public function getAddToCart(Request $request, $id){
 //        $sp = new SanPham();
 //        $sanpham = $sp->getProduct($id);
 //        $oldCart = Session::has('cart') ? Session::get('cart') : null;
 //        $cart = new Cart($oldCart);
 //        if($request->input('quantity')){
 //            $cart->add($sanpham, $id, $request->input('quantity'));
 //        }
 //        else{
 //            $cart->add($sanpham, $id, 1);
 //        }
        

 //        $request->session()->put('cart', $cart);
 //        //$request->session()->forget('cart');

 //        if(Session::has('account')){
 //            foreach ($cart->items as $product) {
 //                $giohang = new GioHang([
 //                   'soluong' => $product['qty'],
 //                   'khachhang_id' => Session::get('account')->id,
 //                   'sanpham_id' => $product['item']['id'],
 //                ]);
 //                $checkCart = GioHang::where('khachhang_id', $giohang->khachhang_id)->where('sanpham_id', $giohang->sanpham_id)->update(['soluong' => $giohang->soluong]);
 //                if(!$checkCart){
 //                    $giohang->save();
 //                }
                
 //            }
 //        }
 //        if($request->input('quantity')){
 //            return redirect()->route('shoppingCart');
 //        }
        
 //        return redirect()->route('home');
 //    }






    // ADMIN

    public function autoComplete(Request $request) {
        $query = $request->get('term');
        
        $orders = SanPham::where('id', 'LIKE', '%'.$query.'%')
                    ->orwhere('ten', 'LIKE', '%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->take(6)
                    ->get();
        
        $data=array();
        foreach ($orders as $order) {
                $data[]=array('value'=>'SP - '.$order->id.' - '.$order->ten);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }

    public function searchIndex(Request $request){
        return view('web-bansua-admin.product.timkiemsanpham');
    }

    public function searchProduct(Request $request){
        if(Session::has('search_product')){
            $request->session()->forget('search_product');
        }
        if(Session::has('count_ordered')){
            $request->session()->forget('count_ordered');
        }
        if(Session::has('count_avaiable')){
            $request->session()->forget('count_avaiable');
        }

        $id = $request->input('search_product');
        if(strpos($id, "SP - ") !== false){
            $a = explode(' - ', $id);
            $prodcut_id = $a[1];
            $products = DB::table('sanpham')->where('sanpham.id', $prodcut_id)
                    ->join('thuonghieu', 'sanpham.thuonghieu_id', '=', 'thuonghieu.id')
                    ->join('nhomtuoi', 'sanpham.nhomtuoi_id', '=', 'nhomtuoi.id')
                    ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                    ->get();
            $count_ordered = DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $prodcut_id)
                    ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->where('hoadonxuat.trangthai', 'Đồng ý giao hàng')
                    ->sum('chitietxuat.soluong');
            $count_export = DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $prodcut_id)
                    ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                    ->sum('chitietxuat.soluong');

            $count_avaiable = DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $prodcut_id)
                    ->sum('chitietnhap.soluong');
        }
        // else{
        //     $products = DB::table('sanpham')->where('sanpham.id', 'LIKE', '%'.$id.'%')
        //             ->orwhere('sanpham.ten', 'LIKE', '%'.$id.'%')
        //             ->join('thuonghieu', 'sanpham.thuonghieu_id', '=', 'thuonghieu.id')
        //             ->join('nhomtuoi', 'sanpham.nhomtuoi_id', '=', 'nhomtuoi.id')
        //             ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
        //             ->orderBy('sanpham.id', 'asc')
        //             ->take(10)
        //             ->get();

        // }
        if(!empty($products)){
            $request->session()->put('search_product', $products);
        }
        if(!empty($count_ordered)){
            $request->session()->put('count_ordered', $count_ordered);
        }
        if(!empty($count_avaiable)){
            $request->session()->put('count_avaiable',  $count_avaiable - $count_export);
        }

        return redirect()->back();
    }


    public function productIndex(Request $request){

        $nhomtuoi = NhomTuoi::all();
        $thuonghieu = ThuongHieu::all();
        return view('web-bansua-admin.product.danhmucsanpham', ['thuonghieu'=>$thuonghieu, 'nhomtuoi'=>$nhomtuoi]);
    }

    public function search_product_by_key(Request $request){
        if(isset($_GET['searchProduct'])){
            $nhomtuoi = $_GET['option_selected1'];
            $thuonghieu = $_GET['option_selected2'];
            $id = $_GET['search_product'];
            if($id !== ''){
                if(strpos($id, "SP - ") !== false){
                    $a = explode(' - ', $id);
                    $products = DB::table('sanpham')->where('sanpham.id', $a[1])
                            ->join('thuonghieu', 'sanpham.thuonghieu_id', '=', 'thuonghieu.id')
                            ->join('nhomtuoi', 'sanpham.nhomtuoi_id', '=', 'nhomtuoi.id')
                            ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                            ->get();
                }
                else{
                    $products = DB::table('sanpham')->where('sanpham.id', 'LIKE', '%'.$id.'%')
                                ->orwhere('sanpham.ten', 'LIKE', '%'.$id.'%')
                                ->join('thuonghieu', 'sanpham.thuonghieu_id', '=', 'thuonghieu.id')
                                ->join('nhomtuoi', 'sanpham.nhomtuoi_id', '=', 'nhomtuoi.id')
                                ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                                ->orderBy('sanpham.id', 'asc')
                                ->take(10)
                                ->get();
                    }
            }
            
            else{
                if($nhomtuoi === 'Tất cả' && $thuonghieu === 'Tất cả'){
                    // $products = DB::table('sanpham')->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')->join('nhomtuoi', 'nhomtuoi.id', '=', 'sanpham.nhomtuoi_id')
                    //     ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                    //     ->get();
                }
                elseif ($nhomtuoi !== 'Tất cả' && $thuonghieu === 'Tất cả') {
                    $products = DB::table('sanpham')->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')->join('nhomtuoi', 'nhomtuoi.id', '=', 'sanpham.nhomtuoi_id')
                        ->where('nhomtuoi.tuoi', $nhomtuoi)
                        ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                        ->get();
                }
                elseif ($nhomtuoi === 'Tất cả' && $thuonghieu !== 'Tất cả'){
                    $products = DB::table('sanpham')->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')->join('nhomtuoi', 'nhomtuoi.id', '=', 'sanpham.nhomtuoi_id')
                        ->where('thuonghieu.ten', $thuonghieu)
                        ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                        ->get();
                }
                elseif ($nhomtuoi !== 'Tất cả' && $thuonghieu !== 'Tất cả'){
                    $products = DB::table('sanpham')->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')->join('nhomtuoi', 'nhomtuoi.id', '=', 'sanpham.nhomtuoi_id')
                        ->where('nhomtuoi.tuoi', $nhomtuoi)
                        ->where('thuonghieu.ten', $thuonghieu)
                        ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                        ->get();
                }
                
            }

            if(!empty($products)){
                $request->session()->put('search_product_by_key', $products);
            }

            return redirect()->back();
        }
    
    }


    public function updateProduct(Request $request, $id){
        if(isset($_POST['cap-nhat'])){
            $img_product = null;

            if ($request->uploadFile){
                $this->validate($request, [
                   'uploadFile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                date_default_timezone_set("Asia/Ho_Chi_minh");
                $destinationPath = public_path().'\images';
                $ex = $request->uploadFile->getClientOriginalExtension();
                $fileName = time().'.'.$ex;
                $request->file('uploadFile')->move($destinationPath, $fileName);
                $img_product = $fileName;
            }

            $name_product = $request->name_product;
            $giaban_product = $request->giaban_product;
            $discount_product = $request->discount_product;
            $thuonghieu = $_POST['option_thuonghieu_'.$id];
            $nhomtuoi = $_POST['option_nhomtuoi_'.$id];
            $mota = $_POST['mota_product_'.$id];
            

            $id_thuonghieu = ThuongHieu::where('ten',$thuonghieu)->first();
            $id_nhomtuoi = NhomTuoi::where('tuoi',$nhomtuoi)->first();

            if($img_product !== null){
                $product = SanPham::where('id', $id)->update(['ten' => $name_product, 'giaban'=>$giaban_product, 'anh'=>$img_product, 'discount'=>$discount_product, 'thuonghieu_id'=>$id_thuonghieu->id, 'nhomtuoi_id'=>$id_nhomtuoi->id, 'mota'=>$mota]);
            }
            else{
                $product = SanPham::where('id', $id)->update(['ten' => $name_product, 'giaban'=>$giaban_product, 'discount'=>$discount_product, 'thuonghieu_id'=>$id_thuonghieu->id, 'nhomtuoi_id'=>$id_nhomtuoi->id, 'mota'=>$mota]);
            }

            if(Session::has('search_product_by_key')){
                $list = Session::get('search_product_by_key');
                foreach ($list as $key => $value) {
                     if($value->id == $id){
                         $p = DB::table('sanpham')->where('sanpham.id', $id)->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')->join('nhomtuoi', 'nhomtuoi.id', '=', 'sanpham.nhomtuoi_id')
                        ->select('sanpham.*', 'nhomtuoi.tuoi as tuoi', 'thuonghieu.ten as tenthuonghieu')
                        ->get();
                    }
                }
                 $request->session()->forget('search_product_by_key');
                 $request->session()->put('search_product_by_key', $p);
            }

        }

        return redirect()->back();
        
    }

    public function addIndex()
    {
        $nhomtuoi = NhomTuoi::all();
        $thuonghieu = ThuongHieu::all();
        return view('web-bansua-admin.product.themmoi', ['thuonghieu'=>$thuonghieu, 'nhomtuoi'=>$nhomtuoi]);
    } 

    public function addNewProduct(Request $request){
        if(isset($_POST['them_moi'])){
            $img_product = null;

            if ($request->uploadFileImg){
                $this->validate($request, [
                   'uploadFileImg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                date_default_timezone_set("Asia/Ho_Chi_minh");
                $destinationPath = public_path().'\images';
                $fileName = time().'.'.$request->uploadFileImg->getClientOriginalExtension();
                $request->file('uploadFileImg')->move($destinationPath, $fileName);
                $img_product = $fileName;
            }

            $thuonghieu = $_POST['option_thuonghieu'];
            $nhomtuoi = $_POST['option_nhomtuoi'];
            $mota = $_POST['mota_product_add'];

            $id_thuonghieu = ThuongHieu::where('ten',$thuonghieu)->first();
            $id_nhomtuoi = NhomTuoi::where('tuoi',$nhomtuoi)->first();

            $sp = new SanPham([
                'ten' => $request->name_product,
                'giaban' => $request->giaban_product,
                'anh' => $img_product,
                'discount' => $request->discount_product,
                'thuonghieu_id' => $id_thuonghieu->id,
                'nhomtuoi_id' => $id_nhomtuoi->id,
                'mota' => $mota,
            ]);
            $sp->save();
            $max_id = DB::table('sanpham')->max('id');
            $product = DB::table('sanpham')->where('sanpham.id', $max_id)
                        ->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')
                        ->join('nhomtuoi', 'sanpham.nhomtuoi_id', '=', 'nhomtuoi.id')
                        ->select('sanpham.*', 'thuonghieu.ten as tenthuonghieu', 'nhomtuoi.tuoi as tuoi')
                        ->get();
            $request->session()->put('search_product_by_key', $product);
            return redirect()->route('quanlysanpham');
        }
        if(isset($_POST['huy_them_moi'])){
            $this->addIndex();
        }

        return redirect()->back();
    }


    public function importExcel(Request $request){
        if(isset($_POST['import_excel'])){
            $max_id = DB::table('sanpham')->max('id');
            Excel::load(Input::file('uploadFileExcel'), function($reader){
                $reader->each(function($sheet){
                    foreach ($sheet->toArray() as $row) {
                        SanPham::firstOrCreate($sheet->toArray());
                    }
                });
            });
            $max = DB::table('sanpham')->max('id');
            $min = $max_id + 1;
            if($max > $max_id){
                $product = DB::table('sanpham')->whereBetween('sanpham.id', [$min, $max])
                        ->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')
                        ->join('nhomtuoi', 'sanpham.nhomtuoi_id', '=', 'nhomtuoi.id')
                        ->select('sanpham.*', 'thuonghieu.ten as tenthuonghieu', 'nhomtuoi.tuoi as tuoi')
                        ->get();
                $request->session()->put('search_product_by_key', $product);
                return redirect()->route('quanlysanpham');
            }
        }
        if(isset($_POST['cancel_import_excel'])){
            $this->addIndex();
        }
        return redirect()->back();
    }







    // thuong hieu, nhom tuoi

    public function get_list_trademark(Request $request){


        $listTrademark=DB::table('thuonghieu')->get();  
        return view('web-bansua-admin.product.danhsachthuonghieu', ['listTrademark' => $listTrademark]);

    }
    

     public function  searchTrademarkByKey(Request $request){
        $key = $request->input('search-trademark');
        
        $list_trademark = DB::table('thuonghieu')->select(DB::raw('thuonghieu.*'))   
                                              ->where('id', 'LIKE', "%{$key}%")  
                                              ->orWhere( 'ten', 'LIKE', "%{$key}%")
                                              ->orWhere( 'nuoc', 'LIKE', "%{$key}%")                   
                                              ->take(10)->get();
        return view('web-bansua-admin.product.danhsachthuonghieu', ['listTrademark' => $list_trademark, 'keySearch' => $key]);
     }
      public function addTrademark(Request $request){
         $name = $request->input('input_name_trademark');        
         $nation = $request->input('input_nation_trademark');       
         DB::table('thuonghieu')->insert(
                  ['ten' => $name, 'nuoc' => $nation]
            );
         return redirect()->route('trademark');
     }
      public function changeTrademark(Request $request){
        $id = $request->input('input_id_trademark');        
         $name = $request->input('input_name_trademark');        
         $nation = $request->input('input_nation_trademark');
              
         DB::table('thuonghieu')
            ->where('id', $id)
            ->update( ['ten' => $name, 'nuoc' => $nation]);
         $listTrademark = DB::table('thuonghieu')->where('thuonghieu.id', $id)->get();
         return view('web-bansua-admin.product.danhsachthuonghieu', ['listTrademark' => $listTrademark]);
     }
     //
     public function get_list_age_group(Request $request){

        $listAgeGroup=DB::table('nhomtuoi')->get();
        $arr = array();
        foreach ($listAgeGroup as $value) {
              $list = explode('-', $value->tuoi);
              $arr[$value->id][0] = $list[0];
              $arr[$value->id][1] = $list[1];
          }  
        return view('web-bansua-admin.product.danhsachnhomtuoi', ['listAgeGroup' => $listAgeGroup, 'arr' => $arr]);

    }
    public function  searchAgeGroupByKey(Request $request){
        $key = $request->input('search-age-group');
        
        $list_age_group=DB::table('nhomtuoi')->select(DB::raw('nhomtuoi.*'))   
                                              ->where('id', 'LIKE', "%{$key}%")  
                                              ->orWhere( 'tuoi', 'LIKE', "%{$key}%")           
                                               ->take(10)->get();
        return view('web-bansua-admin.product.danhsachnhomtuoi', ['listAgeGroup' => $list_age_group, 'keySearch' => $key]);
    }
    public function addAgeGroup(Request $request){
        $from = $request->input('input_from'); 
        $to = $request->input('input_to');
        if($from > $to) {
            $tuoi=(string)$to . "-" .(string)$from;
        } 
        else{
            $tuoi=(string)$from . "-" .(string)$to;
        }     
        DB::table('nhomtuoi')->insert(
             ['tuoi' => $tuoi]  );

        return redirect()->route('age-group');
     }
      public function changeAgeGroup(Request $request){
        $id = $request->input('input_id_age_group');        
        $from = $request->input('input_from'); 
          $to = $request->input('input_to'); 
          if($from<=$to) {
                $tuoi=(string)$from . "-" .(string)$to;
          } 
          else{
              $tuoi=(string)$to . "-" .(string)$from;
            }
         DB::table('nhomtuoi')
            ->where('id', $id)
            ->update( ['tuoi' => $tuoi]);
         $listAgeGroup=DB::table('nhomtuoi')->where('nhomtuoi.id', $id)->get();  
        return redirect()->route('age-group');
     
     }


    // Thống kê hàng hóa

     public function statisticIndex(){
        $arrAvaiable = ['Tồn kho', 'Hết hàng'];
        $arrOption = ['Ngày', 'Tháng', 'Năm'];
        $arrOptionTime = ['01', '02','03','04','05', '06', '07', '08','09', '10',
        '11', '12','13','14','15', '16', '17', '18','19', '20',
        '21', '22','23','24','25', '26', '27', '28','29', '30', '31'];
        $listProduct = null;
        $list = null;
        $number = null;

        return view('web-bansua-admin.statistics-report.thongkehanghoa', ['arrAvaiable' => $arrAvaiable, 'arrOption' => $arrOption, 'arrOptionTime' => $arrOptionTime, 'listProduct' => $listProduct, 'list' => $list, 'number' => $number]);
     }


    public function statisticProduct(Request $request){

        if(isset($_POST['searchProduct'])){
            $data = $_POST['option_selected_avaiable'];

            if($data == 'Hết hàng'){
                $arr = $this->checkAvaiable($data);
                if(!empty($arr)){
                    
                    $listProduct = $this->getProduct($arr);
                    $list = null;
                    $number = null;
                    $arrAvaiable = ['Hết hàng', 'Tồn kho'];
                    $arrOption = null;
                    $arrOptionTime = null;
                    return view('web-bansua-admin.statistics-report.thongkehanghoa', ['arrAvaiable' => $arrAvaiable, 'arrOption' => $arrOption, 'arrOptionTime' => $arrOptionTime, 'listProduct' => $listProduct, 'list' => $list, 'number' => $number]);
                }
                
            }

            else if($data == 'Tồn kho'){
                $time;
                $array = $this->checkAvaiable($data);
                if(!empty($array)){
                    $selectTime = $_POST['option_selected_time'];
                    $select = $_POST['option_time'];

                    if($selectTime == "Ngày"){
                        $time = $select;
                    }
                    else if($selectTime == "Tháng"){
                        $time = $select * 30;
                    }
                    else if($selectTime == "Năm"){
                        $time = $select * 365;
                    }

                    $listProductID = DB::table('chitietnhap')->whereIn('chitietnhap.sanpham_id', $array)
                                        ->whereBetween('chitietnhap.hansudung', array(Carbon::now(), Carbon::now()->addDays($time)))
                                        ->get();

                    
                    $arr = array();
                    $number = array();
                    $flag = array();

                    foreach ($listProductID as $value) {
                        if(empty($flag)){
                            array_push($flag, $value->sanpham_id);
                        }
                        else{
                            $b = true;
                            foreach ($flag as $key) {
                                if($value->sanpham_id === $key){
                                    $b = false;
                                }
                            }
                            if($b){
                                array_push($flag, $value->sanpham_id);
                            }
                        }
                    }

                    foreach ($flag as $value) {

                        $avai = DB::table('chitietnhap')->where('sanpham_id', $value)->whereBetween('chitietnhap.hansudung', array(Carbon::now(), Carbon::now()->addDays($time)))
                            ->sum('chitietnhap.soluong');

                        $export = DB::table('chitietxuat')->where('sanpham_id', $value)->whereBetween('chitietxuat.hansudung', array(Carbon::now(), Carbon::now()->addDays($time)))
                            ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                            ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                            ->sum('chitietxuat.soluong');

                        $number[$value] = $avai - $export;
                        array_push($arr, $value);
                    }

                    $listProduct = null;
                    $list = $this->getProduct($arr);
                    $arrAvaiable = ['Tồn kho', 'Hết hàng'];
                    if($selectTime === 'Ngày'){
                        $arrOption = ['Ngày', 'Tháng', 'Năm'];
                    } else if($selectTime === 'Tháng'){
                        $arrOption = ['Tháng', 'Năm', 'Ngày'];
                    } else if($selectTime === 'Năm'){
                        $arrOption = ['Năm', 'Tháng', 'Ngày'];
                    }
                    
                    $arrOptionTime = $arrOptionTime = [$select,'01', '02','03','04','05', '06', '07', '08','09', '10','11', '12','13','14','15', '16', '17', '18','19', '20',
                     '21', '22','23','24','25', '26', '27', '28','29', '30', '31'];


                    return view('web-bansua-admin.statistics-report.thongkehanghoa', ['arrAvaiable' => $arrAvaiable, 'arrOption' => $arrOption, 'arrOptionTime' => $arrOptionTime, 'listProduct' => $listProduct, 'list' => $list, 'number' => $number]);
                }
                
            }
        }
    }

    public function getProduct($arr){
        $listProduct = DB::table('sanpham')->whereIn('sanpham.id', $arr)
         ->join('thuonghieu', 'thuonghieu.id', '=', 'sanpham.thuonghieu_id')
         ->join('nhomtuoi', 'nhomtuoi.id', '=', 'sanpham.nhomtuoi_id')
         ->select('sanpham.*', 'thuonghieu.ten as tenthuonghieu', 'nhomtuoi.tuoi as tuoi')
         ->distinct()
         ->get();

        return $listProduct;
    }


    public function checkAvaiable($check){
        $arr = array();
        $listProductId = DB::table('sanpham')->get();
        foreach ($listProductId as $value) {
            $count_export = DB::table('chitietxuat')->where('chitietxuat.sanpham_id', $value->id)
                    ->join('hoadonxuat', 'hoadonxuat.id', '=', 'chitietxuat.hoadonxuat_id')
                    ->whereIn('hoadonxuat.trangthai',['Đã xuất kho', 'Thành công'])
                    ->sum('chitietxuat.soluong');

            $count_avaiable = DB::table('chitietnhap')->where('chitietnhap.sanpham_id', $value->id)
                    ->sum('chitietnhap.soluong');
            if($check == 'Hết hàng'){
                if($count_avaiable <= $count_export){
                    array_push($arr, $value->id);
                }
            }
            else if($check == 'Tồn kho'){
                if($count_avaiable > $count_export){
                    array_push($arr, $value->id);
                }
            }
            
        }
        return $arr;
    }


}
