@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">

    <div class="col-md-5">
      <h3 class="text-info">Danh sách nhân viên</h3>
    </div>
    <br/>
    <div class="col-md-2">
      <button type="button" style="font-size: 12px" class="btn btn-primary" data-toggle="modal" data-target="#newAccount">
        Thêm mới
      </button>
      <div class="modal fade" id="newAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Thông tin nhân viên</h4>
            </div>
            <div class="modal-body">


              <form class="form-horizontal" method="post" action="{{ url('nhan-vien/them-moi', ['manv' => $manv_them]) }}">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="manv_them">Mã nhân viên:</label>
                  <div class="col-sm-6">
                    <label class="form-control">{{ $manv_them }}</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="password_them">Mật khẩu:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="password_them" name="password_them" placeholder="Nhập mật khẩu" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="ht_them">Họ tên:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="ht_them" name="ht_them" placeholder="Nhập họ tên" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="sdt_them">Số điện thoại:</label>
                  <div class="col-sm-6">
                    <input type="tel" class="form-control" id="sdt_them" name="sdt_them" placeholder="Nhập sđt" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="cmt_them">Số CMT:</label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control" id="cmt_them" name="cmt_them" placeholder="Nhập số cmt" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="diachi_them">Địa chỉ:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="diachi_them" name="diachi_them" placeholder="Nhập địa chỉ" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="chucvu_them">Chức vụ:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="chucvu_them" name="chucvu_them" placeholder="Nhập chức vụ" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="chucvu">Trạng thái:</label>
                  <div class="col-sm-6">
                    <select style="width: 150px" class="selectpicker form-control" name="option_trangthai_them">

                      <option>Hoạt động</option>
                      <option>Khóa</option>

                    </select>
                  </div>
                </div>

                <br/><br/>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-4">
                    <center><input type="submit" class="btn btn-success" name="them-moi" id="them-moi" value="Thêm mới"></center>
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

    <br/><br/>
    
  </div>
  <br/><br/>
  <table class="table table-hover table-bordered table-striped" id="myTable">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã nhân viên</center></th>
        <th><center>Họ tên</center></th>
        <th><center>Số ĐT</center></th>
        <th><center>Số CMT</center></th>
        <th><center>Địa chỉ</center></th>
        <th><center>Chức vụ</center></th>
        <th><center>Trạng thái</center></th>
        <th><center>Cập nhật</center></th>
        <th><center>Quyền</center></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $STT=0;
      ?>
      @foreach($staffs as $staff)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td><center>{{ $staff->manv }}</center></td>
        <td><center>{{ $staff->ten }}</center></td>
        <td><center>{{ $staff->sdt }}</center></td>
        <td><center>{{ $staff->cmt }}</center></td>
        <td><center>{{ $staff->diachi }}</center></td>
        <td><center>{{ $staff->chucvu }}</center></td>
        <td><center>@if($staff->status == 1) Hoạt động @else Khóa @endif</center></td>
        <td><center>
          <button type="button" style="font-size: 12px" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myAccount-{{$staff->manv}}">
            Edit
          </button>
        </center>
        <!-- Modal -->
        <div class="modal fade" id="myAccount-{{$staff->manv}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông tin nhân viên</h4>
              </div>
              <div class="modal-body">


                <form class="form-horizontal" method="post" action="{{ url('nhan-vien/cap-nhat', ['manv' => $staff->manv]) }}">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="ht">Họ tên:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="ht" name="ht" value="{{ $staff->ten }}" required="" aria-required="true">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="sdt">Số điện thoại:</label>
                    <div class="col-sm-6">
                      <input type="tel" class="form-control" id="sdt" name="sdt" value="{{ $staff->sdt }}" required="" aria-required="true">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cmt">Số CMT:</label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="cmt" name="cmt" value="{{ $staff->cmt }}" required="" aria-required="true">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="diachi">Địa chỉ:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="diachi" name="diachi" value="{{ $staff->diachi }}" required="" aria-required="true">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="chucvu">Chức vụ:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="chucvu" name="chucvu" value="{{ $staff->chucvu }}" required="" aria-required="true">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="chucvu">Trạng thái:</label>
                    <div class="col-sm-6">
                      <select style="width: 150px" class="selectpicker form-control" name="option_trangthai">
                        @if($staff->status == 1)
                        <option>Hoạt động</option>
                        <option>Khóa</option>
                        @else
                        <option>Khóa</option>
                        <option>Hoạt động</option>
                        @endif
                      </select>
                    </div>
                  </div>

                  <br/><br/><br/>
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                      <center><input type="submit" class="btn btn-success" name="cap-nhat" id="cap-nhat" value="Cập nhật"></center>
                      {{ csrf_field() }}
                    </div>
                  </div>
                </form>
                <br/><br/>
              </div>

            </div>
          </div>
        </div>

      </td>

      <td><center>
        <button type="button" style="font-size: 12px" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myAccountRole-{{$staff->manv}}">
          Role
        </button>
      </center>
      <!-- Modal -->
      <div class="modal fade" id="myAccountRole-{{$staff->manv}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Các quyền của nhân viên - {{$staff->ten}}</h4>
            </div>
            <div class="modal-body">

              <form action="{{ url('nhan-vien/phan-quyen', ['manv' => $staff->manv]) }}" method="post">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 50px"><center><label><input type="checkbox" name="checkAll-{{ $staff->manv }}" id="checkAll-{{ $staff->manv }}" ></label></center></th>
                      <th style="width: 100px"><center>STT</center></th>
                      <th><center>Quyền</center></th>
                    </tr>
                  </thead>
                  <script type="text/javascript">
                      $('document').ready(function(){
                          $("#checkAll-{{ $staff->manv }}").click(function(){
                               if ($(this).is(':checked')) {
                                      $(".checkbox").prop("checked", true);
                               } else {
                                      $(".checkbox").prop("checked", false);
                               }
                          });
                      });
                  </script>
                  <tbody>
                    <?php $stt=0 ?>
                    @foreach($roles as $role)
                    <tr>
                    @if(strpos($arr[$staff->manv],(string)$role->id) !== false)
                    
                    <td><center><label><input checked="true" type="checkbox" name="quyen-{{ $staff->manv }}[]" id="quyen-{{ $staff->manv }}[]" class="checkbox" value="{{$role->id}}"></label></center></td>
                    @else
                    <td><center><label><input type="checkbox" name="quyen-{{ $staff->manv }}[]" id="quyen-{{ $staff->manv }}[]" class="checkbox" value="{{$role->id}}"></label></center></td>
                    @endif
                    
                    <td><center><?php echo ++$stt ?></center></td>
                    <td><center>{{ $role->tenquyen }}</center></td>
                    </tr>
                    @endforeach

                  </tbody>

                </table>

                <br/>
                <div>
                  <center><input type="submit" role="button" id="phanquyen-{{ $staff->manv }}" name="phanquyen-{{ $staff->manv }}" class="btn btn-primary" value="Xác nhận"></center>
                  {{ csrf_field() }}
                </div>
              </form>
                <br/><br/>

            </div>

          </div>
        </div>
      </div>

    </td>
  </tr>
  @endforeach

</tbody>

</table>
<br/><br/><br/><br/>
</div>

<script >
    var x= document.getElementById("nhanvien");
    x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection