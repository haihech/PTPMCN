@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">
   <h3 class="text-info"><b><center>Thông tin tài khoản</center></b></h3>
 </div>

 <?php
 $STT=0;
 ?>

 <div class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-4" >Mã tài khoản:</label>
    <div class="col-sm-6">
      <label class="control-label">{{ Session::get('admin')->manv }}</label>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-4" for="option_provider">Mật khẩu:</label>
    <div class="col-sm-6">
      <label class="control-label">{!! Session::get('admin')->password !!}</label>
   </div>
 </div>

 <div class="form-group">
  <label class="control-label col-sm-4" for="sanpham">Tên nhân viên:</label>
  <div class="col-sm-6">
    <label class="control-label">{{ Session::get('admin')->ten }}</label>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-4" for="number">Số điện thoại:</label>
  <div class="col-sm-6">
    <label class="control-label">{{ Session::get('admin')->sdt }}</label>
  </div>
</div>
<div class="form-group">
  <label class="control-label col-sm-4" for="giaNhap">Số CMTND:</label>
  <div class="col-sm-6">
    <label class="control-label">{{ Session::get('admin')->cmt }}</label>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-4" for="han_su_dung">Địa chỉ:</label>
  <div class="col-sm-6">
    <label class="control-label">{{ Session::get('admin')->diachi }}</label>
  </div>
  
</div>
<div class="form-group">
  <label class="control-label col-sm-4" for="han_su_dung">Chức vụ:</label>
  <div class="col-sm-6">
    <label class="control-label">{{ Session::get('admin')->chucvu }}</label>
  </div>
  
</div>

</div>
<br/><br/>
<div>
  <center><a href="#" type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateAccount">Cập nhật tài khoản</a></center>
  <div class="modal fade" id="updateAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Thông tin nhân viên</h4>
            </div>
            <div class="modal-body">


              <form class="form-horizontal" method="post" action="{{ route('capnhattaikhoancanhan') }}">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="manv_them">Mã nhân viên:</label>
                  <div class="col-sm-6">
                    <label class="form-control" id="manv_them">{{ Session::get('admin')->manv }}</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="password_them">Mật khẩu:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="password_them" name="password_them" required="" aria-required="true" value="{{ Session::get('admin')->password }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="ht_them">Tên nhân viên:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="ht_them" name="ht_them" required="" aria-required="true" value="{{ Session::get('admin')->ten }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="sdt_them">Số điện thoại:</label>
                  <div class="col-sm-6">
                    <input type="tel" class="form-control" id="sdt_them" name="sdt_them" value="{{ Session::get('admin')->sdt }}" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="cmt_them">Số CMT:</label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control" id="cmt_them" name="cmt_them" value="{{ Session::get('admin')->cmt }}" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="diachi_them">Địa chỉ:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="diachi_them" name="diachi_them" value="{{ Session::get('admin')->diachi }}" required="" aria-required="true">
                  </div>
                </div>
                

                <br/><br/>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-4">
                    <center><input type="submit" class="btn btn-success" name="cap-nhat" id="them-moi" value="Xác nhận"> </center>
                    {{ csrf_field() }}
                  </div>
                </div>
              </form>
              <br/><br/>
            </div>

          </div>
        </div>
      </div>
</div>


<br/><br/><br/><br/>
</div>



@endsection