@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12 ">
  <div class="main-right">
    <div class="timkiem">

      <h3 class="text-info">Đơn hàng đã xuất kho ( {{$i}} đơn hàng )</h3>
      <!-- <div class="col-md-5">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Nhập mã đơn hàng hoặc tên khách hàng...">
          <span class="input-group-btn">
            <button class="btn btn-success" type="button">Tìm kiếm!</button>
          </span>
        </div>
      </div> -->
    </div>
  </div>
  <br/><br/>
  <form action="{{ route('capnhattrangthai') }}" method="get">
    <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><label><input type="checkbox" name="checkAll" id="checkAll" ></label></th>
          <th><center>STT</center></th>
          <th><center>Mã ĐH</center></th>
          <th><center>Ngày tạo</center></th>
          <th><center>Khách hàng</center></th>
          <th><center>Trạng thái</center></th>
          <th><center>Tổng tiền</center></th>
          <th><center>Địa chỉ giao hàng</center></th>
          <th><center>Người giao hàng</center></th>
        </tr>
      </thead>
      <tbody>
        <?php $stt = 0 ?>
        @foreach($orders as $order)
        <tr>
          <td><center><label><input type="checkbox" name="donhang[]" id="donhang[]" class="checkbox" value="{{ $order->id }}"></label></center></td>
          <td><center><?php echo ++$stt ?></center></td>
          <td style="width: 80px"><center><a href="#">{{ $order->id }}</a></center></td>
          <td style="width: 60px"><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td><center>{{ $order->tenkh }}</center></td>
          <td><center>{{ $order->trangthai }}</center></td>
          <td style="width: 120px"><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
          <td><center>{{ $order->diachigiaohang }}</center></td>
          <td style="width: 100px"><center>{{ $order->gh }}</center></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>
      <h4 class="modal-title" id="myModalLabel">Cập nhật trạng thái đơn hàng</h4>
    </div>

    <div class="modal-body">

      <div class="chonnguoigiaohang">
        <p>
          <select class="selectpicker form-control" style="width: 250px" name="option_selected">
            <option>Thành công</option>
            <option>Trả lại</option>
            <option>Giao hàng không thành công</option>
          </select>
        </p>

      </div>

    </div>
    <div>
      <center><input type="submit" role="button" name="capnhattrangthai" class="btn btn-primary" value="Xác nhận cập nhật"></center>
      {{ csrf_field() }}
    </div>
  </form>


  <br/><br/><br/><br/><br/><br/>
</div>

</div>

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
    x.getElementsByTagName("a")[3].className="active";

</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection