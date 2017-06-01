@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12 ">
  <div class="main-right">
    <div class="timkiem">
      <br/>
      <form action="{{url('/search_comleted')}}" method="get">
        <div class="col-md-6">
          <div class="input-group">
            <input type="text" id="search_comleted_order" name="search_comleted_order" class="form-control" placeholder="Nhập mã đơn hàng hoặc tên khách hàng...">
            <div class="input-group-btn">
              <input type="submit" class="btn btn-primary" value="Tìm kiếm!" role="button">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <br/><br/><br/>
  @if(Session::has('orders'))
  <form action="{{ route('updateStatusCompleted') }}" method="get">
    <table class="table table-hover table-bordered">
      <thead>
        <tr>
          <th><label><input type="checkbox" name="checkAll" id="checkAll" ></label></th>
          <th><center>STT</center></th>
          <th><center>Mã đơn hàng</center></th>
          <th><center>Ngày tạo</center></th>
          <th><center>Khách hàng</center></th>
          <th><center>Trạng thái</center></th>
          <th><center>PT thanh toán</center></th>
          <th style="width: 150px"><center>Tổng tiền</center></th>
          <th><center>Địa chỉ giao hàng</center></th>
          <th><center>Người giao hàng</center></th>
        </tr>
      </thead>
      <tbody>
      <?php $stt = 0 ?>
        @foreach(Session::get('orders') as $order)
        <tr>
          <td><label><input type="checkbox" name="donhang[]" id="donhang[]" class="checkbox" value="{{ $order->id }}"></label></td>
          <td><center><?php echo ++$stt ?></center></td>
          <td><center><a href="#">{{ $order->id }}</a></center></td>
          <td><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td><center>{{ $order->tenkh }}</center></td>
          <td><center>{{ $order->trangthai }}</center></td>
          <td><center>{{ $order->phuongthucthanhtoan }}</center></td>
          <td><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
          <td><center>{{ $order->diachigiaohang }}</center></td>
          <td><center>{{ $order->nguoigiaohang }}</center></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div>
      <h4 class="modal-title" id="myModalLabel">Cập nhật trạng thái đơn hàng</h4>
    </div>

    <div class="modal-body">

      <div class="chonnguoigiaohang ">
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
  @endif

</div>


<br/><br/><br/><br/><br/><br/>

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
<script>
   $(document).ready(function() {
    src = "{{ route('search_comleted') }}";
     $("#search_comleted_order").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        min_length: 1,
       
    });
});
</script>
<script >
    var x= document.getElementById("donhang");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[4].className="active";

</script>

@endsection