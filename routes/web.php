<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get("home?page={pages}",'HomeController@getPages()');

Route::get('nhomtuoi/{nhomtuoiId}', ['as' => 'nhomtuoi', 'uses' => 'HomeController@groupByNhomTuoi']);
Route::get('thuonghieu/{thuonghieuId}', ['as' => 'thuonghieu', 'uses' => 'HomeController@groupByThuongHieu']);

Route::group(['middleware' => 'web'], function () {

	// Route::get('/home', ['uses' => 'ProductController@getAllProduct', 'as' => 'home']);
 //    Route::post('/home', ['uses' => 'ProductController@getAllProduct', 'as' => 'home']);
	// Route::get('/home/search', 'ProductController@search');
 //    Route::get('/search', 'ProductController@searchProductByKey');
	// Route::get('/products/{id}', 'ProductController@productDetail');
 //    Route::get('/mota', 'ProductController@getNote');

 //    Route::get('/addtocart/{id}', ['uses' => 'ProductController@getAddToCart', 'as' => 'add-to-cart']);
    
 //    Route::get('/shopping-cart', ['uses' => 'CartController@getCart', 'as' => 'shoppingCart']);
 //    Route::get('/shopping-cart/{id}', 'CartController@removeProduct');
 //    Route::post('/update-cart', 'CartController@updateCart');

	// Route::get('/checkout', 'CartController@checkOut');
 //    Route::post('/order-bill', 'CartController@orderBill');
 //    Route::post('/signup' , 'UserController@postSignup');
 //    Route::get('/signup', function(){
 //    	return view('web-bansua.signup');
 //    });
 //    Route::post('/signin' , 'UserController@postSignin');
    
 //    Route::get('/signin', function(){
 //    	return view('web-bansua.signin');
 //    });
 //    Route::get('/logout', ['uses' => 'UserController@getLogout', 'as' => 'logout']);


    // web

    Route::post('/web-bansua/signup' , ['uses' => 'UserController@postSignup', 'as' => 'register']);
    Route::post('/web-bansua/signin' , 'UserController@postSignin');
    Route::get('/web-bansua/logout', ['uses' => 'UserController@getLogout', 'as' => 'web-bansua.logout']);
    Route::get('/web-bansua/loadProduct/{index}/{nums}/{thuonghieu}/{nhomtuoi}/{giamgia}','ProductController@getMoreProducts');
    Route::get('/web-bansua/loadSlide','AdvertiseController@loadSlide');
    Route::get('/web-bansua/loadNews','AdvertiseController@loadNews');
    Route::get('/web-bansua/loadKhuyenMai/{b}/{index?}','AdvertiseController@loadKhuyenMai');
    Route::get('/web-bansua/loadHot/{time}/{b}/{index?}','AdvertiseController@getHotProduct');


    Route::get('/web-bansua/products/{id}',['as'=>'product','uses'=>'ProductController@productDetail']);
     Route::get('/web-bansua/addtocart/{id}/{sl}', ['uses' => 'ProductController@getAddToCart', 'as' => 'web-bansua.add-to-cart']);

    Route::get('/web-bansua/home', ['uses' => 'ProductController@getAllProduct', 'as' => 'web-bansua.home']);
   

    Route::get('/web-bansua/shopping-cart', ['uses' => 'CartController@getCart', 'as' => 'web-bansua.shoppingCart']);
    Route::post('/web-bansua/update-cart', 'CartController@updateCart');
    Route::get('/web-bansua/checkout','CartController@checkOut');
     Route::post('/web-bansua/order-bill',['as'=>'web-bansua.orderBill','uses'=> 'CartController@orderBill']);


    Route::get('web-bansua/thuonghieu/{id}','ProductController@getThuongHieu');
    Route::get('web-bansua/nhomtuoi/{id}','ProductController@getNhomTuoi');
    Route::get('/web-bansua/hot','ProductController@getHot');
    Route::get('/web-bansua/khuyenmai','ProductController@getKhuyenMai');
    Route::get('/web-bansua/giamgia','ProductController@getGiamGia');



    Route::get('/web-bansua/home/search', 'ProductController@search');


    // admin


    Route::get('/signin-admin', function(){
            return view('web-bansua-admin.sign-in');
        });
    Route::post('/signin-admin' , 'StaffController@postSignin');

    Route::group(['middleware' => 'admin'], function () {

        // tai khoan ca nhan

        Route::get('/tai-khoan-ca-nhan', ['uses'=>'StaffController@accountPro', 'as'=>'taikhoancanhan']);
        Route::post('/tai-khoan-ca-nhan', ['uses'=>'StaffController@updateAccountPro', 'as'=>'capnhattaikhoancanhan']);

        // trang chu

        Route::get('/logout-admin', 'StaffController@logOut');
        Route::get('/trang-chu', ['uses' => 'StaffController@index', 'as' => 'home-admin']);


        // Xử lý đơn hàng
        Route::get('/tim-kiem-don-hang', ['uses' => 'OrderController@search', 'as' => 'timkiemdonhang']);
        Route::get('/tim-kiem-don-hang/search', ['uses' => 'OrderController@searchOrder', 'as' => 'search_order']);
        Route::get('/searchajax',['as'=>'searchajax','uses'=>'OrderController@autoComplete']);

        Route::get('/don-hang-cho-xu-ly', ['uses' => 'OrderController@waitProcess', 'as' => 'choxuly']);
        Route::get('/don-hang-cho-xu-ly/cap-nhat', 'OrderController@updateCustomer');
        Route::get('/cap-nhat-don-hang/{id}', ['uses' => 'OrderController@updateOrder', 'as' => 'updateOrder']);
        Route::get('/xac-nhan-don-hang/{id}', ['uses' => 'OrderController@confirmOrder', 'as' => 'confirmOrder']);
        Route::get('/huy-don-hang/{id}', ['uses' => 'OrderController@cancelOrder', 'as' => 'cancelOrder']);

        Route::get('/don-hang-da-xac-nhan', ['uses' => 'OrderController@confirmed', 'as' => 'confirmed']);
        Route::get('/don-hang-da-xac-nhan/tim-kiem', ['uses' => 'OrderController@search_confirmed', 'as' => 'timkiem_xacnhan']);
        Route::get('/phan-cong-don-hang', ['uses' => 'OrderController@division', 'as' => 'phancong']);
        Route::get('/don-hang-da-xuat-kho', ['uses' => 'OrderController@exported', 'as' => 'daxuatkho']);
        Route::get('/cap-nhat-trang-thai-don-hang', ['uses' => 'OrderController@updateStatus', 'as' => 'capnhattrangthai']);
        Route::get('/cap-nhat-trang-thai-don-hang-hoan-thanh', ['uses' => 'OrderController@updateStatusCompleted', 'as' => 'updateStatusCompleted']);
        Route::get('/don-hang-da-hoan-thanh', ['uses' => 'OrderController@comleted', 'as' => 'dahoanthanh']);
        Route::get('/search_comleted', ['uses' => 'OrderController@search_comleted_order', 'as' => 'searchcomleted']);
        Route::get('/search_autocomplete', ['uses' => 'OrderController@search_autocomplete', 'as' => 'search_comleted']);


        // Sản phẩm

        Route::get('/tim-kiem-san-pham', ['uses' => 'ProductController@searchIndex', 'as' => 'timkiemsanpham']);
        Route::get('/searchajax_product',['as'=>'searchajax_product','uses'=>'ProductController@autoComplete']);
        Route::get('/tim-kiem-san-pham/tim-kiem', ['uses' => 'ProductController@searchProduct', 'as' => 'search_product']);

        Route::get('/danh-muc-san-pham', ['uses' => 'ProductController@productIndex', 'as' => 'quanlysanpham']);
        Route::get('/danh-muc-san-pham/tim-kiem', ['uses' => 'ProductController@search_product_by_key', 'as' => 'searchproductbykey']);

        Route::post('/danh-muc-san-pham/cap-nhat/{id}', 'ProductController@updateProduct');

        Route::get('/danh-muc-san-pham/nhap-san-pham/', ['uses'=>'ProductController@addIndex', 'as' => 'themmoi']);
        Route::post('/danh-muc-san-pham/them-moi-san-pham', ['uses'=>'ProductController@addNewProduct', 'as' => 'themmoisanpham']);
        Route::post('/danh-muc-san-pham/them-sp-excel', ['uses'=>'ProductController@importExcel', 'as' => 'import_excel']);

        //khach hang
        Route::get('/danh-sach-khach-hang', ['uses' => 'CustomerController@get_infor_customer', 'as' => 'danhsachkhachhang']);
        Route::get('/search-customer', ['uses' => 'CustomerController@searchCustomerByKey', 'as' => 'search-customer']);
        //nha cung cap
        Route::get('/danh-sach-nha-cung-cap', ['uses' => 'ProviderController@get_list_provider', 'as' => 'danhsachnhacungcap']);
        Route::get('/search-provider', ['uses' => 'ProviderController@searchProviderByKey', 'as' => 'search-provider']);
        Route::get('/add-provider', ['uses' => 'ProviderController@addProvider', 'as' => 'add-provider']);
        Route::get('/change-provider', ['uses' => 'ProviderController@changeProvider', 'as' => 'change-provider']);
        //thuong hieu
        Route::get('/trademark', ['uses' => 'ProductController@get_list_trademark', 'as' => 'trademark']);
        Route::get('/search-trademark', ['uses' => 'ProductController@searchTrademarkByKey', 'as' => 'search-trademark']);
        Route::get('/add-trademark', ['uses' => 'ProductController@addTrademark', 'as' => 'add-trademark']);
        Route::get('/change-trademark', ['uses' => 'ProductController@changeTrademark', 'as' => 'change-trademark']);
        //nhom tuoi
        Route::get('/age-group', ['uses' => 'ProductController@get_list_age_group', 'as' => 'age-group']);
        Route::get('/search-age-group', ['uses' => 'ProductController@searchAgeGroupByKey', 'as' => 'search-age-group']);
        Route::get('/add-age-group', ['uses' => 'ProductController@addAgeGroup', 'as' => 'add-age-group']);
        Route::get('/change-age-group', ['uses' => 'ProductController@changeAgeGroup', 'as' => 'change-age-group']);

        //xuathang

        Route::get('/xuat-hang', ['uses' => 'ExportController@index', 'as' => 'xuathang']);
        Route::get('/xuat-hang/tim-kiem', ['uses' => 'ExportController@searchOrder', 'as' => 'timkiemgiaohang']);
        Route::get('/xuat-hang/hansudung-soluong', 'ExportController@getInfo');
        Route::get('/xuat-hang/soluong', 'ExportController@getNumberProduct');
        Route::get('/xuat-hang/luu-hoa-don-xuat', 'ExportController@saveExport');
        Route::get('/xuat-hang/dong', function(){
            return redirect()->back();
        });
        Route::get('/xuat-hang/in-hoa-don/{id}', 'ExportController@getPDF');

        // nhan vien
        Route::get('/nhan-vien', ['uses' => 'StaffController@indexAccount', 'as' => 'danhsachnhanvien']);
        Route::post('/nhan-vien/cap-nhat/{manv}', ['uses' => 'StaffController@updateAccount', 'as' => 'capnhattaikhoan']);
        Route::post('/nhan-vien/them-moi/{manv}', ['uses' => 'StaffController@addAccount', 'as' => 'themmoitaikhoan']);
        Route::post('/nhan-vien/phan-quyen/{manv}', ['uses' => 'StaffController@distributeRole', 'as' => 'phanquyen']);

        // thu tien
        Route::get('/thu-tien', ['uses' => 'DepositController@indexDeposit', 'as' => 'thutien']);
        Route::get('/tim-kiem-khach-hang', ['uses' => 'DepositController@autoComplete', 'as' => 'search_customer']);
        Route::get('/tim-kiem-don-hang/tim-kiem', ['uses' => 'DepositController@autoCompleteOrder', 'as' => 'search_order_ajax']);
        Route::get('/tao-phieu-thu/{pttt}/{ngaythu}/{sotienthu}', ['uses' => 'DepositController@createDeposit', 'as' => 'tao_phieu_thu']);
        Route::get('/thu-tien/tim-kiem', ['uses' => 'DepositController@search', 'as'=>'timkiem_thutien']);


        // chi tien
        Route::get('/chi-tien', ['uses' => 'PayController@indexPay', 'as' => 'chitien']);

        Route::get('/chi-tien/tim-kiem-don-hang', ['uses' => 'PayController@autoCompleteOrder', 'as' => 'search_order_import_ajax']);
        Route::get('/tao-phieu-chi', ['uses' => 'PayController@createPay', 'as' => 'tao_phieu_chi']);

        // nhap hang

        Route::get('/import', ['uses' => 'ImportController@import', 'as' => 'import']);
        Route::get('/import_return', ['uses' => 'ImportController@importReturn', 'as' => 'import_return']);
        Route::get('/add_import', ['uses' => 'ImportController@addImport', 'as' => 'add_import']);
        Route::get('/searchajax_export',['as'=>'searchajax_exporauto','uses'=>'ImportController@autoComplete']);
        Route::get('/searchexportbykey',['as'=>'searchexportbykey','uses'=>'ImportController@search_export_by_key']);
        Route::get('/submit-turn-export',['as'=>'submit-turn-export','uses'=>'ImportController@submitReturnExport']);
        Route::get('/nhap-hang/in-hoa-don/{id}', 'ImportController@getImportPDF');
        Route::get('/nhap-hang/in-hoa-don', 'ImportController@getPDF');

        // danh sach nhap xuat

        Route::get('/danh-sach-nhap-xuat', ['uses'=> 'ImportController@listIndex', 'as' => 'danhsachnhapxuat']);
        Route::get('/danh-sach-nhap-xuat/tim-kiem', ['uses' => 'ImportController@searchOrderImportExport' , 'as' => 'tim_kiem_nhap_xuat']);

        // danh sach thu chi

        Route::get('/danh-sach-thu-chi', ['uses' => 'DepositController@listIndex', 'as' => 'danhsachthuchi']);
        Route::get('/danh-sach-thu-chi/tim-kiem', ['uses' => 'DepositController@searchDepositAndPay' , 'as' => 'tim_kiem_thu_chi']);

        // thong ke san pham

        Route::get('/thong-ke-san-pham', ['uses' => 'ProductController@statisticIndex', 'as' => 'thongkesanpham']);
        Route::post('/thong-ke-san-pham', ['uses' => 'ProductController@statisticProduct', 'as' => 'thong_ke_san_pham']);
        Route::post('/thong-ke-san-pham/ban-chay', ['uses' => 'ProductController@bestProduct', 'as' => 'thong_ke_san_pham_ban_chay']);

        // thong ke cong no

        Route::get('/thong-ke-cong-no', ['uses' => 'DepositController@statisticIndex', 'as' => 'thongkecongno']);
        
    });
   
});