@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">
  <div class="main-right">
      <br/>
      <div class="col-md-9">
      <form action="{{ route('timkiem_xacnhan') }}" method="get" class="navbar-form">
      <div class="col-md-6">
          <table>
            <tr>
              <td style="width: 75px">Đơn hàng:</td>
              <td>
                <select style="width: 220px" class="selectpicker form-control" name="option_selected1">
                  @foreach($arr as $s)
                   <option>{{ $s }}</option>
                  @endforeach
                </select>
              </td>
            </tr>

          </table>
        </div>

        <div class="input-group">
          <input type="submit" class="btn" id="icon-search" name="timkiemxacnhan" value="Tìm kiếm" style="text-indent:17px;">
        </div>
      </form>
    </div>
    
    <br/><br/><br/>
    <center><h4 class="text-info">Danh sách đơn hàng ( {{$i}} đơn hàng )</h4></center>
    <hr>
    <form action="{{ route('phancong') }}" method="get">
    <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><label><input type="checkbox" name="checkAll" id="checkAll" ></label></th>
          <th><center>STT</center></th>
          <th><center>Mã ĐH</center></th>
          <th><center>Ngày tạo</center></th>
          <th><center>Khách hàng</center></th>
          <th><center>Trạng thái</center></th>
          <th><center>Địa chỉ giao hàng</center></th>
          <th><center>Tổng tiền</center></th>
          <th><center>Người giao hàng</center></th>
        </tr>
      </thead>
      <tbody>
        <?php $STT=0 ?>
        @foreach($orders as $order)
        <tr>
          <td><center><label><input type="checkbox" onclick="handleClick(this);" name="donhang[]" id="donhang" class="checkbox" value="{{ $order->id }}"></label></center></td>
          <td><center><?php echo ++$STT ?></center></td>
          <td style="width: 80px"><center><a href="#">{{ $order->id }}</a></center></td>
          <td style="width: 60px"><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td><center>{{ $order->tenkh }}</center></td>
          <td><center>{{ $order->trangthai }}</center></td>
          <td><center>{{ $order->diachigiaohang }}</center></td>
          <td style="width: 120px"><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
          <td style="width: 120px"><center>{{ $order->nguoigiaohang }}</center></td>
        </tr>
        @endforeach
      </tbody>
    </table>

          <div>
            <h4 class="modal-title" id="myModalLabel">Chọn người giao hàng</h4>
          </div>
          
          <div class="modal-body">

            <div class="chonnguoigiaohang">
              <p>
                <select class="selectpicker form-control" style="width: 250px" name="option_selected">
                @foreach($giaohang as $gh)
                  <option>{{ $gh->ten }} - {{ $gh->manv }}</option>
                @endforeach
                </select>
              </p>
              
            </div>

          </div>
          <div>
            <center><input type="submit" role="button" name="phancong" class="btn btn-primary" value="Xác nhận giao hàng"></center>
                {{ csrf_field() }}
          </div>
    </form>
    <br/><br/><br/><br/><br/><br/>
  </div>

</div>
<!-- 
<script>
  function handleClick(cb) {
    alert(cb.value);
  }
</script>   -->


<script type="text/javascript">
    $('document').ready(function(){
        $("#checkAll").click(function(){
             if ($(this).is(':checked')) {
                $(".checkbox").prop("checked", true);
             } else {
                $(".checkbox").prop("checked", false);
             }
        });
    });
</script>


<script >
    var x= document.getElementById("donhang");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[2].className="active";

</script>


<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection