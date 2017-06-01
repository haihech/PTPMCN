<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\NhanVien;
use App\Quyen;
use App\PhanQuyen;
use DB;
use Carbon\Carbon;

class StaffController extends Controller
{
    
    public function postSignin(Request $request){
    	$nv = NhanVien::where('manv', $request->input('manv'))->first();
    	if($nv){
    		if($nv->password == $request->input('password')){
                $request->session()->put('admin', $nv);
                $roles = DB::table('phanquyen')
                    ->where('nhanvien_manv', $nv->manv)
                    ->join('quyen', 'phanquyen.quyen_id', '=', 'quyen.id')
                    ->select('quyen.id as role_id', 'quyen.tenquyen as role_name')->get();
                $request->session()->put('role', $roles);
                $str_roles = "";
                foreach ($roles as $value) {
                    $str_roles .= " ".(string)$value->role_id;
                }
                $request->session()->put('str_roles', $str_roles);
                return redirect('trang-chu');
    	    }
    	}
    	
        return view('web-bansua-admin.sign-in');
    	
    }

    public function logOut(Request $request){
        $request->session()->forget('search_product');
        $request->session()->forget('count_ordered');
        $request->session()->forget('count_avaiable');
        $request->session()->forget('dataExportBill');
        $request->session()->forget('dataDetailExport');
        $request->session()->forget('nameKH');

        $request->session()->forget('search_product_by_key');
        $request->session()->forget('str_roles');
        $request->session()->forget('admin');
        $request->session()->forget('role');
        return redirect('signin-admin');
    }

    public function format_Time($time){
        $date=date_create($time);
        return date_format($date,"m");
    }

    public function index(){
        $now = Carbon::now();
        $now_month = $now->month;
        $now_year = $now->year;

        $listOrders = array();
        $revenue = array();
        
        // thang now_month
        $time1 = Carbon::create($now_year, $now_month, 1, 0,0,0);
        $order1 = DB::table('hoadonxuat')->whereNotIn('trangthai', ['Chờ xử lý'])->whereBetween('created_at', array($time1, Carbon::now()))->count();
        $order11 = DB::table('hoadonxuat')->where('trangthai', 'Thành công')->whereBetween('created_at', array($time1, Carbon::now()))->count();

        $t11 = Carbon::create($now_year-1, $now_month, 1, 0,0,0);
        $t12 = Carbon::create($now_year-1, $now_month, 30, 23,59,59);
        $deposit1 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                            ->whereBetween('ngaythu', array($time1, Carbon::now()))->sum('chitietthu.sotienthu');
        $deposit11 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                            ->whereBetween('ngaythu', array($t11, $t12))->sum('chitietthu.sotienthu');

        //thang now_monnth-1
        if ($now_month-1 > 0) {
            $t2 = Carbon::create($now_year, $now_month-1, 1, 0,0,0);
            $t22 = Carbon::create($now_year, $now_month-1, 30, 23,59,59);
            $t221 = Carbon::create($now_year-1, $now_month-1, 1, 0,0,0);
            $t222 = Carbon::create($now_year-1, $now_month-1, 30, 23,59,59);
        }
        else{
            $t2 = Carbon::create($now_year-1, $now_month-1+12, 1, 0,0,0);
            $t22 = Carbon::create($now_year-1, $now_month-1+12, 30, 23,59,59);
            $t221 = Carbon::create($now_year-2, $now_month-1+12, 1, 0,0,0);
            $t222 = Carbon::create($now_year-2, $now_month-1+12, 30, 23,59,59);
            
        }
        $order2 = DB::table('hoadonxuat')->whereNotIn('trangthai', ['Chờ xử lý'])->whereBetween('created_at', array($t2, $t22))->count();
        $order22 = DB::table('hoadonxuat')->where('trangthai', 'Thành công')->whereBetween('created_at', array($t2, $t22))->count();
        $deposit2 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t2, $t22))->sum('chitietthu.sotienthu');
        $deposit22 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t221, $t222))->sum('chitietthu.sotienthu');


        //thang now_monnth-2
        if ($now_month-2 > 0) {
            $t3 = Carbon::create($now_year, $now_month-2, 1, 0,0,0);
            $t33 = Carbon::create($now_year, $now_month-2, 30, 23,59,59);
            $t331 = Carbon::create($now_year-1, $now_month-2, 1, 0,0,0);
            $t332 = Carbon::create($now_year-1, $now_month-2, 30, 23,59,59);
        }
        else{
            $t3 = Carbon::create($now_year-1, $now_month-2+12, 1, 0,0,0);
            $t33 = Carbon::create($now_year-1, $now_month-2+12, 30, 23,59,59);
            $t331 = Carbon::create($now_year-2, $now_month+10, 1, 0,0,0);
            $t332 = Carbon::create($now_year-2, $now_month+10, 30, 23,59,59);
            
        }
        $order3 = DB::table('hoadonxuat')->whereNotIn('trangthai', ['Chờ xử lý'])->whereBetween('created_at', array($t3, $t33))->count();
        $order33 = DB::table('hoadonxuat')->where('trangthai', 'Thành công')->whereBetween('created_at', array($t3, $t33))->count();

        $deposit3 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t3, $t33))->sum('chitietthu.sotienthu');
        $deposit33 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t331, $t332))->sum('chitietthu.sotienthu');

        //thang now_monnth-3
        if ($now_month-3 > 0) {
            $t4 = Carbon::create($now_year, $now_month-3, 1, 0,0,0);
            $t44 = Carbon::create($now_year, $now_month-3, 30, 23,59,59);
            $t441 = Carbon::create($now_year-1, $now_month-3, 1, 0,0,0);
            $t442 = Carbon::create($now_year-1, $now_month-3, 30, 23,59,59);
        }
        else{
            $t4 = Carbon::create($now_year-1, $now_month+9, 1, 0,0,0);
            $t44 = Carbon::create($now_year-1, $now_month+9, 30, 23,59,59);
            $t441 = Carbon::create($now_year-2, $now_month+9, 1, 0,0,0);
            $t442 = Carbon::create($now_year-2, $now_month+9, 30, 23,59,59);
        }
        $order4 = DB::table('hoadonxuat')->whereNotIn('trangthai', ['Chờ xử lý'])->whereBetween('created_at', array($t4, $t44))->count();
        $order44 = DB::table('hoadonxuat')->where('trangthai', 'Thành công')->whereBetween('created_at', array($t4, $t44))->count();

        $deposit4 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t4, $t44))->sum('chitietthu.sotienthu');
        $deposit44 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t441, $t442))->sum('chitietthu.sotienthu');


        //thang now_monnth-4
        if($now_month-4 > 0){
            $t5 = Carbon::create($now_year, $now_month-4, 1, 0,0,0);
            $t55 = Carbon::create($now_year, $now_month-4, 30, 23,59,59);
            $t551 = Carbon::create($now_year-1, $now_month-4, 1, 0,0,0);
            $t552 = Carbon::create($now_year-1, $now_month-4, 30, 23,59,59);
        }
        else{
            $t5 = Carbon::create($now_year-1, $now_month+8, 1, 0,0,0);
            $t55 = Carbon::create($now_year-1, $now_month+8, 30, 23,59,59);
            $t551 = Carbon::create($now_year-2, $now_month+8, 1, 0,0,0);
            $t552 = Carbon::create($now_year-2, $now_month+8, 30, 23,59,59);
        }
        $order5 = DB::table('hoadonxuat')->whereNotIn('trangthai', ['Chờ xử lý'])->whereBetween('created_at', array($t5, $t55))->count();
        $order55 = DB::table('hoadonxuat')->where('trangthai', 'Thành công')->whereBetween('created_at', array($t55, $t55))->count();
        $deposit5 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t5, $t55))->sum('chitietthu.sotienthu');
        $deposit55 = DB::table('phieuthu')->join('chitietthu', 'chitietthu.phieuthu_id', '=', 'phieuthu.id')
                                ->whereBetween('ngaythu', array($t551, $t552))->sum('chitietthu.sotienthu');
        
        array_push($listOrders,array('y' => $t5->month,'a' => $order5,'b' => $order55 ));
        array_push($listOrders,array('y' => $t4->month,'a' => $order4,'b' => $order44 ));
        array_push($listOrders,array('y' => $t3->month,'a' => $order3,'b' => $order33 ));
        array_push($listOrders,array('y' => $t2->month,'a' => $order2,'b' => $order22 ));
        array_push($listOrders,array('y' => $now_month,'a' => $order1,'b' => $order11 ));

        array_push($revenue,array('y' => $t5->year.'-'.$t5->month,'a' =>number_format($deposit55/1000000),'b' =>number_format($deposit5/1000000) ));
        array_push($revenue,array('y' => $t4->year.'-'.$t4->month,'a' =>number_format($deposit44/1000000),'b' => number_format($deposit4/1000000)));
        array_push($revenue,array('y' => $t3->year.'-'.$t3->month,'a' => number_format($deposit33/1000000),'b' => number_format($deposit3/1000000) ));
        array_push($revenue,array('y' => $t2->year.'-'.$t2->month,'a' => number_format($deposit22/1000000),'b' => number_format($deposit2/1000000) ));
        array_push($revenue,array('y' => $time1->year.'-'.$time1->month,'a' => number_format($deposit11/1000000),'b' => number_format($deposit1/1000000) ));
        
        
        return view('web-bansua-admin.home.home', ['listOrders'=>$listOrders, 'revenue' =>$revenue]);
    }

    
    public function indexAccount(){

        $staffs = NhanVien::All();
        $manv_them = '';
        if(empty($staffs)){
            $manv_them = 'nv-0001';
        }
        else{
            $count = count($staffs) + 1;
            if($count < 10){
                $manv_them = 'nv-000'.$count;
            }
            else if($count < 100){
                $manv_them = 'nv-00'.$count;
            }
            else if($count < 1000){
                $manv_them = 'nv-0'.$count;
            }
            else{
                $manv_them = 'nv-'.$count;
            }
        }

        $arr;
        $roles = DB::table('quyen')->get();
        
        foreach ($staffs as $staff) {
            $role = DB::table('phanquyen')->where('nhanvien_manv', $staff->manv)->get();
            $str_roles = "";
            foreach ($role as $value) {
                $str_roles .= " ".(string)$value->quyen_id;
            }
            $a[$staff->manv] = $str_roles;
            $arr[$staff->manv] = $str_roles;
            
            
        }

        return view('web-bansua-admin.account.nhanvien', ['staffs' => $staffs, 'manv_them' => $manv_them, 'arr' => $arr, 'roles' => $roles]);
    }

    public function updateAccount(Request $request, $manv){
        if(isset($_POST['cap-nhat'])){

            $name = $_POST['ht'];
            $phone = $_POST['sdt'];
            $cmt = $_POST['cmt'];
            $addr = $_POST['diachi'];
            $role = $_POST['chucvu'];
            $status = $_POST['option_trangthai'];
            if($status === 'Hoạt động'){
                $update = DB::table('nhanvien')->where('manv', $manv)->update(['ten' => $name, 'sdt'=>$phone, 'cmt'=>$cmt, 'diachi'=>$addr, 'chucvu'=>$role, 'status'=>'1']);
            }
            else{
                $update = DB::table('nhanvien')->where('manv', $manv)->update(['ten' => $name, 'sdt'=>$phone, 'cmt'=>$cmt, 'diachi'=>$addr, 'chucvu'=>$role, 'status'=>'0']);
            }

            return redirect()->route('danhsachnhanvien');
        }
    }

    public function addAccount($manv){
        if(isset($_POST['them-moi'])){
            $password = bcrypt($_POST['password_them']);
            $name = $_POST['ht_them'];
            $phone = $_POST['sdt_them'];
            $cmt = $_POST['cmt_them'];
            $addr = $_POST['diachi_them'];
            $role = $_POST['chucvu_them'];
            $status = $_POST['option_trangthai_them'];
            if($status === 'Hoạt động'){
                DB::table('nhanvien')->insert([
                    'manv' => $manv,
                    'password' => $password,
                    'ten' => $name,
                    'sdt' => $phone,
                    'cmt' => $cmt,
                    'diachi' => $addr,
                    'chucvu' => $role,
                    'status' => 1
                    ]);
                
            }
            else{
                DB::table('nhanvien')->insert([
                    'manv' => $manv,
                    'password' => $password,
                    'ten' => $name,
                    'sdt' => $phone,
                    'cmt' => $cmt,
                    'diachi' => $addr,
                    'chucvu' => $role,
                    'status' => 0
                    ]);
            }

            return redirect()->route('danhsachnhanvien');
        }
    }

    public function distributeRole($manv){
        if(isset($_POST['phanquyen-'.$manv])){
            if(isset($_POST['quyen-'.$manv])){
                DB::table('phanquyen')->where('nhanvien_manv', $manv)->delete();
                foreach ($_POST['quyen-'.$manv] as $value) {
                    DB::table('phanquyen')->insert(
                      ['quyen_id' => $value, 'nhanvien_manv' => $manv] );
                }
            }
        }
        // echo '<script language="javascript">';
        // echo 'alert("Thành công")';
        // echo '</script>';
        
        return redirect()->route('danhsachnhanvien');
    }

    public function accountPro(){
        return view('web-bansua-admin.account.taikhoan');
    }


    public function updateAccountPro(){
        if (isset($_POST['cap-nhat'])) {
            $manv = Session::get('admin')->manv;
            $password = $_POST['password_them'];
            $name = $_POST['ht_them'];
            $phone = $_POST['sdt_them'];
            $cmt = $_POST['cmt_them'];
            $addr = $_POST['diachi_them'];
            $update = DB::table('nhanvien')->where('manv', $manv)->update(['password'=>$password, 'ten' => $name, 'sdt'=>$phone, 'cmt'=>$cmt, 'diachi'=>$addr]);
            
            $nv = NhanVien::where('manv', $manv)->first();
            Session::forget('admin');
            Session::put('admin', $nv);

            return view('web-bansua-admin.account.taikhoan');
        }
    }

}
