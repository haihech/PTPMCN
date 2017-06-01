@extends('web-bansua-admin.index')
@section('content')
<div class="col-md-12">
  <div class="main-right">
    <div class="timkiem">

      <h3 class="text-info">Danh sách khách hàng</h3>

      <div class="col-md-6">
        <div class="input-group">
        
              <form action="{{ url('search-customer') }}" method="get" class="navbar-form navbar-left" >
                  <div class="input-group">
                      <div class="ui-widget">
                        <input type="text" id="search-customer" name="search" class="form-control" placeholder="Nhập mã, tên hoặc số điện thoại...">
                        <div class="dropdown-menu" id="productList" role="menu"></div>
                      </div>
                            
                  </div>
                  <div class="input-group">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                  </div>
              </form>
        </div>
      </div>
    </div>
    <br/><br/><br/> <br/>
    <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã KH</center></th>
          <th><center>Tên khách hàng</center></th>
          <th><center>Số điện thoại</center></th>
          <th><center>Email</center></th>
          <th><center>Địa chỉ</center></th>
          <th><center>Điểm thưởng</center></th>     
          <th><center>Lịch sử mua hàng</center></th>     
        </tr>
      </thead>
      <tbody>
      <?php
      $STT=0;
      ?>
               
        @foreach($listCustomer as $customer)
        <tr>
          <th><center><?php echo ++$STT?></center></th>          
          <td><center><center>{{$customer->id}}</center></td>
          <td><center>{{$customer->ten}}</center></td>
          <td><center>{{$customer->sdt}}</center></td>
          <td><center>{{$customer->email}}</center></td>
          <td style="width: 200px"><center>{{$customer->diachi}}</center></td>
          <td><center>{{$customer->diemthuong}}</center></td>          
           <td><center><a href="" data-toggle="modal" data-target="#myModal-{{$customer->id}}" type="button" class="btn btn-success btn-sm">Xem ngay</a></center>

            <!-- Modal -->
            <div class="modal fade" id="myModal-{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Lịch sử mua hàng của khách hàng: {{$customer->ten}}</h4>
                  </div>
                  <div class="modal-body">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Mã đơn hàng</center></th>
                            <th><center>Ngày mua</center></th>
                            <th><center>Trạng thái</center></th>
                            <th><center>Tổng tiền</center></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arr[$customer->id] as $order)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $order->id }}</center></td>
                            <td><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
                            <td><center>{{ $order->trangthai }}</center></td>
                            <td><center><?php echo number_format($order->total_sales + $order->phiship ).' ' ?><u>đ</u></center></td>
                          </tr>
                          @endforeach
                          </tbody>

                        </table>

                           
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
    <br/><br/>


  </div>  
</div>

<script >
    var x= document.getElementById("khachhang");
    x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>
@endsection

