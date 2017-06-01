<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\SanPham;
use Session;
use Redirect;
use App\GioHang;
use App\Cart;
use Illuminate\Support\Facades\Input;
use Validator;

class UserController extends Controller
{
    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
    }
    public function postSignup(Request $request){
        $validation = Input::only('username', 'email', 'password', 'password_confirmation');
        $data = array(
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => \Hash::make(Input::get('password')),
            'ten'=>'',
            'sdt'=>'',
            'diachi'=>'',
            'diemthuong'=>0,
        );
        $validator = $this->validator($validation);
        if ($validator->fails()) {
            $errors = ($validator->errors()->getMessages());
            return redirect()->back()->witherrors($errors)->withInput()->with('showFormRegister',1);
        }
        $user = User::create($data);
        Auth::login($user);

        $cart = Session::get('cart');
        if($cart!=null){
            $list=$this->getCart();
            foreach ($cart->listSp as $key => $product) {
                if(in_array($product, $list)){
                    $x=GioHang::where('sanpham_id',$product)->first();
                    $x->soluong+=$cart->listNum[$key];
                    $x->save();
                }else{
                    GioHang::create(['soluong' =>$cart->listNum[$key] ,
                   'khachhang_id' => Auth::user()->id,
                   'sanpham_id' => $product])->save();
                }
            }
        }
      
        
        
        $request->session()->put('account', $user);
        
        return redirect()->back();
    }
    public function getCart(){
        return GioHang::where('khachhang_id',Auth::user()->id)->pluck('sanpham_id')->all();
    }

    public function postSignin(Request $request){
        if(Auth::check()) Auth::logout();
        $userdata = array(
            'username' => Input::get('username'), //tên cột là name
            'password' => Input::get('password'),
        );
        if (Auth::attempt($userdata)) {
            if(Session::has('cart')){
                $cart = Session::get('cart');
                $list=$this->getCart();
                foreach ($cart->listSp as $key=> $product) {
                if(in_array($product, $list)){
                    $x=GioHang::where('sanpham_id',$product)->first();
                    $x->soluong+=$cart->listNum[$key];
                    $x->save();
                }else{
                    GioHang::create(['soluong' =>$cart->listNum[$key] ,
                   'khachhang_id' => Auth::user()->id,
                   'sanpham_id' => $product])->save();
                }
            }
        
            
            }
            return Redirect::back();
            
        }else{
            return Redirect::back()->with('showFormLogin',1);
        }
        
    }

    public function getLogout(Request $request){
        Auth::logout();
        session()->forget('cart');
        $request->session()->forget('account');
        return redirect()->back();
    }

}
