@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12 ">
  <div class="main-right">
    <div class="timkiem">
      <br/>
      <div class="col-md-6">
        <form action="{{route('search_order')}}" method="get">

          <div class="input-group search-bar">
            <input type="text" id="search_order" name="search_order" class="form-control search-field" placeholder="Nhập mã đơn hàng hoặc tên khách hàng...">
            <div class="input-group-btn">
              <input type="submit" class="btn btn-primary" value="Tìm kiếm!" role="button">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <br/><br/><br/>
  @if(Session::has('search_orders'))
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã đơn hàng</center></th>
        <th><center>Ngày tạo</center></th>
        <th><center>Khách hàng</center></th>
        <th><center>Trạng thái</center></th>
        <th><center>Tổng tiền</center></th>
        <th><center>PT thanh toán</center></th>
        <th><center>Địa chỉ giao hàng</center></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $STT=0;
      ?>
      @foreach(Session::get('search_orders') as $order)
      <tr>
         <th><center><?php echo ++$STT?></center></th>
        <td><center>{{ $order->id }}</center></td>
        <td><center>{{ $order->created_at }}</center></td>
        <td><center>{{ $order->tenkh }}</center></td>
        <td><center>{{ $order->trangthai }}</center></td>
        <td><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
        <td><center>{{ $order->phuongthucthanhtoan }}</center></td>
        <td><center>{{ $order->diachigiaohang }}</center></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
  <br/><br/><br/><br/><br/>
</div>


<script>
   $(document).ready(function() {
    src = "{{ route('searchajax') }}";
     $("#search_order").autocomplete({
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

<!-- <script >

 var x= document.getElementById("toggleDemo3");
    x.className="collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";

    x.firstElementChild.getElementsByTagName("li")[0].className="active liActive";

</script> -->
<script >
   var x= document.getElementById("donhang");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[0].className="active";

</script>

@endsection