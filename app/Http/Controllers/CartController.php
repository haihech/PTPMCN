<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Auth;
use App\Cart;
use App\GioHang;
use App\HoaDonXuat;
use App\ChiTietXuat;
use App\Sp;
use App\Khachhang;
use App\SanPham;
use App\ThuongHieu;
use App\NhomTuoi;
use App\User;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class CartController extends Controller
{
    public $thuongHieu;
    public $nhomTuoi;
    public function __construct()
    {
        $thuongHieu=new ThuongHieu();
        $nhomTuoi=new NhomTuoi();

        $this->thuongHieu=$thuongHieu->getAll();
        $this->nhomTuoi=$nhomTuoi->getAll();
    }
    public function checkOut(){
        $cart=$this->getC();
        $products=SanPham::whereIn('id',$cart->listSp)->get();
        $listPrice=[];
        foreach ($products as $key => $s) {
            array_push($listPrice, $s->giaban-$s->discount);
        }
        $totalPrice=0;
        foreach ($cart->listNum as $key => $value) {
           $totalPrice+=$cart->listNum[$key]*$listPrice[$key];
        }
        return view('client.check_out',['tuoi'=>$this->nhomTuoi,'thuonghieu'=>$this->thuongHieu,'products' => $products,'listNum'=>$cart->listNum,'listPrice'=>$listPrice,'totalPrice'=>$totalPrice]);
    }
     public function getCartDataBase(){
        return GioHang::where('khachhang_id',Auth::user()->id)->get();
    }
    public function getC(){
        if(Auth::user()){
            $cart = new Cart(0);
            $list=$this->getCartDataBase();
            foreach ($list as $key => $row) {
                 $cart->addSp($row->sanpham_id,$row->soluong);
            }
        }else{
            $cart = new Cart(Session::get('cart'));
        }
        return $cart;
    }
    public function getCart(){
        $cart=$this->getC();
        $products=SanPham::whereIn('id',$cart->listSp)->get();
        $listPrice=[];
        foreach ($products as $key => $s) {
            array_push($listPrice, $s->giaban-$s->discount);
        }
        $totalPrice=0;
        foreach ($cart->listNum as $key => $value) {
           $totalPrice+=$cart->listNum[$key]*$listPrice[$key];
        }
        Session::put('cart',$cart);
        return view('client.cart',['tuoi'=>$this->nhomTuoi,'thuonghieu'=>$this->thuongHieu,'products' => $products,'listNum'=>$cart->listNum,'listPrice'=>$listPrice,'totalPrice'=>$totalPrice]);
    }

    public function fomatDate($time){
        if($time < 10){
            return '0'.$time;
        }
        else{
            return $time;
        }
    }


    public function orderBill(Request $request){
        $ids='';
        if($request){
            if(Session::has('cart')){ 
                if(count(Session::get('cart')->listSp)<=0)return  redirect()->route('web-bansua.home');
                $user;
                if(Auth::user()){
                    $user=Auth::user();
                }else{
                    $user=User::create([
                        'ten' => $request->input('billing_address_full_name'),
                       'sdt' =>  $request->input('billing_address_phone'),
                       'email' =>  $request->input('order_email'),
                        ]);
                    $user->save();
                }

                $selected = $_POST['giaohang'];
                //$selected = '1';
                $ngayGH;

                if($selected == '1'){
                    $now = Carbon::now();
                    $data = Carbon::now()->addWeek();
                    $ngayGH = $now->year.'-'.$this->fomatDate($now->month).'-'.$this->fomatDate($now->day).'/'.$data->year.'-'.$this->fomatDate($data->month).'-'.$this->fomatDate($data->day);
                } else if($selected == '2'){
                    $now = Carbon::now();
                    $data = Carbon::now()->addDays(3);
                    $ngayGH = $now->year.'-'.$this->fomatDate($now->month).'-'.$this->fomatDate($now->day).'/'.$data->year.'-'.$this->fomatDate($data->month).'-'.$this->fomatDate($data->day);
                } else if($selected == '3'){
                    $now = Carbon::now();
                    $ngayGH = $now->year.'-'.$this->fomatDate($now->month).'-'.$this->fomatDate($now->day).'/'.$now->year.'-'.$this->fomatDate($now->month).'-'.$this->fomatDate($now->day);
                }

                $hdxuat = new HoaDonXuat([
                   'khachhang_id'=>$user->id,
                   'diachigiaohang' =>  $request->input('billing_address_note').'-'.$request->input('billing_address_ward').'-'.$request->input('billing_address_district').'-'.$request->input('billing_address_province'),
                   'ngaygiaohang' => $ngayGH,
                   'phuongthucthanhtoan'  => 'COD',
                   'phiship'  => $request->input('phiship'),
                   'trangthai'  => 'Chờ xử lý',
                   'note'  => $request->input('billing_note'),
                ]);
                $hdxuat->save();
                  $ids=$hdxuat->id;
                $cart=Session::get('cart');
                foreach ($cart->listSp as $k=> $id) {
                    $sp = SanPham::find($id);
                    $chitietxuat = new ChiTietXuat([
                        'soluong' => $cart->listNum[$k],
                        'giaban' => $sp->giaban- $sp->discount,
                        'hoadonxuat_id' => $hdxuat->id,
                        'sanpham_id' => $id,
                    ]);
                    $chitietxuat->save();
                }
                $request->session()->forget('cart');
                if(Auth::user()){
                    $gh = GioHang::where('khachhang_id', Auth::user()->id)->delete();
                    
                }
                return view('client.complete-order', ['tuoi'=>$this->nhomTuoi,'thuonghieu'=>$this->thuongHieu,'id' => $ids]);
            }
            
        }
        return redirect()->route('web-bansua.home');
        
    }

    public function removeProduct(Request $request, $id){
        if($request){
            $cart = Session::get('cart');
            $newCart = new Cart(null);
            $sp = new SanPham();
            
            foreach ($cart->items as $product) {
                if($product['item']['id'] != $id){
                    $sanpham = $sp->getProduct($product['item']['id']);
                    $newCart->add($sanpham, $product['item']['id'], $product['qty']);
                }   
                
            }
            $request->session()->forget('cart');
            if ($newCart->items) {
                $request->session()->put('cart', $newCart);
            }
        
            if(Session::has('account')){
                $kh_id = Session::get('account')->id;
                $gh = GioHang::where('khachhang_id', $kh_id)->where('sanpham_id', $id)->get();
                foreach ($gh as $value) {
                    GioHang::destroy($value->id);
                }
                    
            }
            return redirect()->route('web-bansua.shoppingCart');

        }
        return redirect()->route('web-bansua.shoppingCart');
    }

    public function updateCart(Request $request){
        if($request){
            
                $cart = Session::get('cart');
                foreach ($cart->listSp as $key=> $sp) {
                    if(array_key_exists ('number-'.$sp, $request->input())){
                       $cart->listNum[$key]=$request->input('number-'.$sp);
                    }else{
                        unset($cart->listSp[$key]);
                        unset($cart->listNum[$key]);
                        unset($cart->listPrice[$key]);
                    }
                }
                if(Auth::user()){
                    $list= GioHang::where('khachhang_id',Auth::user()->id)->get();
                    foreach ($list as $key => $c) {
                        if(in_array($c->sanpham_id, $cart->listSp)){

                            foreach ($cart->listSp as $key=> $sp){
                                if($sp==$c->sanpham_id){
                                    $c->soluong=$cart->listNum[$key];
                                    $c->save();
                                }
                            }
                        }else{
                            $c->delete();
                        }
                    }
                }
            //    if(count($cart->listSp)==0) Session::forget('cart');
            
            return redirect()->route('web-bansua.shoppingCart');
        }

        return redirect()->route('web-bansua.shoppingCart');
    }

}
