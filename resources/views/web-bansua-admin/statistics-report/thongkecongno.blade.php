@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <!-- <div class="main-right">
    <br/>
      <form class="navbar-form navbar-left" method="post" action="{{ route('thong_ke_san_pham') }}">
        <div class=" form-horizontal">
          <div class="form-group">
            <label class="col-xs-2"> </label>
            <div class="col-xs-6">
              <label style="width: 780px" align="right">Chọn ngày
              <span style="margin-left: 50px">Chọn tháng</span><span style="margin-left: 50px">Chọn năm</span></
            </div>
          </div>
          <div class="form-group">
              
              <label class="control-label col-xs-2" for="option_selected">Thời gian:</label>
              <div class="col-xs-6" id="thoigian">
                <select style="width: 130px" class="selectpicker form-control" name="option_day" id="option_day">
                 
                </select>
                <select style="width: 130px" class="selectpicker form-control" name="option_month" id="option_month">
                  
                </select>
                <select style="width: 130px" class="selectpicker form-control" name="option_year" id="option_year">
                  
                </select>
              </div>
          
            <div class="input-group-btn">
              <input type="submit" class="btn btn-success" value="Thống kê" role="button" name="searchProduct">
            </div>
            {{ csrf_field() }}

           </div>

      </form>
      
  </div> -->

  <br/>
  <h3 class="text-info">Danh sách công nợ</h3>
  <br/><br/>
  @if(!empty($list))
    <table class="table table-hover table-bordered table-striped" id="myTable">
  
    <thead>
      <tr>
        <th><center>Mã hóa đơn</center></th>
        <th><center>Tên khách hàng</center></th>
        <th><center>Người giao hàng</center></th>
        <th><center>Tổng tiền</center></th>
        <th><center>Đã thanh toán</center></th>
        <th><center>Còn nợ</center></th>
      </tr>
    </thead>
    <tbody>
      @foreach($list as $order)
      <tr>
        <td><center>{{ $order->id }}</center></td>
        <td><center>{{ $order->tenkh }}</center></td>
        <td><center>{{ $order->tennv }}</center></td>
        <td><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
        <td><center><?php echo number_format($order->total_deposit).' ' ?><u>đ</u></center></td>
        <td><center><?php echo number_format($order->total_sales + $order->phiship - $order->total_deposit).' ' ?><u>đ</u></center></td>
        
      </tr>
      @endforeach
      
    </tbody>
  
  </table>
   @endif
  
<br/><br/><br/><br/>
</div>
  
</script>

<script >
    var x= document.getElementById("thongke");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[1].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection