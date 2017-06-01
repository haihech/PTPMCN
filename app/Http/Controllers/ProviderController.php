<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\NhaCungCap;
use Session;
use DB;

class ProviderController extends Controller
{
     public function get_list_provider(Request $request){
        $user_id = Session::get('admin')->manv;
        $listProvider = NhaCungCap::All();     
        return view('web-bansua-admin.provider.danhsachnhacungcap', ['listProvider' => $listProvider]);
     }
      public function searchProviderByKey(Request $request){

        $key = $request->input('search-provider');
        
         $list_provider=DB::table('nhacungcap')->select(DB::raw('nhacungcap.*'))   
                                              ->where('id', 'LIKE', "%{$key}%")  
                                              ->orWhere( 'ten', 'LIKE', "%{$key}%")                                                  
                                               ->take(10)->get();
        return view('web-bansua-admin.provider.danhsachnhacungcap', ['listProvider' => $list_provider, 'keySearch' => $key]);
    }
    public function addProvider(Request $request){
         $name = $request->input('input_name_provider');        
         $address = $request->input('input_address_provider');
         $phoneNumber = $request->input('input_phoneNumber_provider');
         $email = $request->input('input_email_provider');
         $fax = $request->input('input_fax_provider');
         $accountNumber = $request->input('input_accountNumber_provider');
         $taxNumber = $request->input('input_taxNumber_provider');
         DB::table('nhacungcap')->insert(
                  ['ten' => $name, 'diachi' => $address, 'sdt' =>$phoneNumber,'email' =>$email,'fax'=>$fax,'sotk'=> $accountNumber, 'masothue'=> $taxNumber]
            );
         return redirect()->route('danhsachnhacungcap');
     }
      public function changeProvider(Request $request){
       $id = $request->input('input_id_provider');        
       $name = $request->input('input_name_provider');        
       $address = $request->input('input_address_provider');
       $phoneNumber = $request->input('input_phoneNumber_provider');
       $email = $request->input('input_email_provider');
       $fax = $request->input('input_fax_provider');
       $accountNumber = $request->input('input_accountNumber_provider');
       $taxNumber = $request->input('input_taxNumber_provider');
       DB::table('nhacungcap')
          ->where('id', $id)
          ->update( ['ten' => $name, 'diachi' => $address, 'sdt' =>$phoneNumber,'email' =>$email,'fax'=>$fax,'sotk'=> $accountNumber, 'masothue'=> $taxNumber]);
          
       $listProvider = DB::table('nhacungcap')->where('nhacungcap.id', $id)->get();
       return view('web-bansua-admin.provider.danhsachnhacungcap', ['listProvider' => $listProvider]);
     }

}
