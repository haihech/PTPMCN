@extends('web-bansua-admin.index')
@section('content')
<div class="col-md-12">
  <div class="main-right">
    <div class="timkiem">

      <h3 class="text-info">Đơn hàng chờ xử lý ( {{$i}} đơn hàng )</h3>
    </div>
    <br/><br/>
    <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã đơn hàng</center></th>
          <th><center>Ngày tạo</center></th>
          <th><center>Khách hàng</center></th>
          <th><center>Địa chỉ giao hàng</center></th>
          <th><center>Trạng thái</center></th>
          <th><center>Tổng tiền </center></th>
        </tr>
      </thead>
      <tbody>
        <?php $STT=0 ?>
        @foreach($orders as $order)
        <tr>
          <th><center><?php echo ++$STT ?></center></th>

          <td><a href="" data-toggle="modal" data-target="#myModal-{{$order->id}}"><center>#{{$order->id}}</center></a>

            <!-- Modal -->
            <div class="modal fade" id="myModal-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thông tin đơn hàng số {{$order->id}}</h4>
                  </div>
                  <div class="modal-body">
                    <h4>1. Thông tin khách hàng:</h4>
                    <div class="thongtinnguoimua form-horizontal">
                      <div>Họ tên: {{ $order->tenkh }}</div>
                      <div>Điện thoại: {{ $order->sdt }}</div>
                      <div>Email: {{ $order->email }}</div>
                      @if($order->note != NULL)
                      <div>Ghi chú: {{ $order->note }}</div>
                      @endif

                      <div>Phương thức thanh toán: {{ $order->phuongthucthanhtoan }}</div>
                      <br/>
                      <div class="form-group">
                        <span class="col-xs-3" for="diachi">Địa chỉ giao hàng:</span>
                        <div class="col-xs-8">
                          <input type="text" class="form-control" id="diachi" name="diachi"  required="" aria-required="true" value="{{ $order->diachigiaohang }}" >
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <span class="col-xs-3">Ngày giao hàng:</span>
                        <div class="col-xs-4">
                          <?php $listDate = explode("/",$order->ngaygiaohang);?>
                          
                          <input id="ngayfrom" class="form-control" size="30" type="date" name="ngayfrom" value="<?php echo $listDate[0] ?>"/>
                          <span> đến </span>
                          <input id="ngayto" class="form-control" size="30" type="date" name="ngayto" value="<?php echo $listDate[1] ?>">
                        </div>

                        <div class="col-xs-4">
                        <br/>
                          <center><button class="btn btn-success" id="capnhat_{{$order->id}}">Cập nhật</button></center>
                        </div>
                      </div>

                      <script>
                         $(document).ready(function($){
                                  $('#capnhat_{{ $order->id }}').click(function(){
                                      var addr = $("#diachi").val();
                                      var from = $("#ngayfrom").val();
                                      var to = $("#ngayto").val();

                                      if(addr == ""){
                                        alert("Bạn chưa nhập địa chỉ");
                                      }

                                      var dataSend = "";
                                      dataSend += addr + "---";
                                      dataSend += from + "---";
                                      dataSend += to + "---";
                                      dataSend += {{$order->id}};

                                      var r = confirm("Bạn có chắc chắn không?");
                                      if(r == true){
                                        $.ajax({

                                          url:'{{URL::to('don-hang-cho-xu-ly/cap-nhat')}}',
                                          method: "GET",
                                          data:{'key': dataSend},
                                          success:function(data){
                                            
                                            alert(data)
                                          }
                                        });
                                      }
                                      else{
                                        return;
                                      }

                                      
                                  });
                              });
                        
                      </script>
                      
                    </div>
                    <hr>
                    <div class="giohang">
                      <h4>2. Giỏ hàng</h4>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Tên sản phẩm</center></th>
                            <th><center>Số lượng</center></th>
                            <th><center>Đơn giá</center></th>
                            <th><center>Thành tiền</center></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arr[$order->id] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->name }}</center></td>
                            <td><center>{{ $detail->soluong }}</center></td>
                            <td><center><?php echo number_format($detail->giaban).' ' ?><u>đ</u></center></td>
                            <td><center><?php echo number_format($detail->giaban * $detail->soluong ).' ' ?><u>đ</u></center></td>
                          </tr>
                          @endforeach
                          </tbody>

                        </table>

                            <div style="margin-left: 260px; font-size: 1.2em">Tổng tiền: <span style="float: right;"><?php echo number_format($order->total_sales).' ' ?><u>đ</u></span></div>
                          
                            <div style="margin-left: 260px; font-size: 1.2em">Phí ship: <span style="float: right"><?php echo number_format($order->phiship).' ' ?><u>đ</u></span></div>
                          
                            <div style="margin-left: 260px; font-size: 1.2em">Số tiền cần thanh toán: <span style="float: right"><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></span></div>
                          
                        <br/><br/>

                      <center><a href="{{url('huy-don-hang', ['id'=>$order->id])}}" role="button" class=" btn btn-warning"> Hủy đơn hàng</a>
                      <a href="{{ url('xac-nhan-don-hang', ['id'=>$order->id]) }}" role="button" class=" btn btn-primary" style="margin-left: 50px;"> Xác nhận đơn hàng</a></center>

                      <br/><br/><br/>
                    </div>

                  </div>

                </div>
              </div>
            </div>

          </td>
          <td style="width: 100px"><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td><center>{{$order->tenkh}}</center></td>
          <td><center>{{ $order->diachigiaohang }}</center></td>
          <td><center>{{$order->trangthai}}</center></td>
          <td style="width: 150px"><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>

        </tr>
        @endforeach
      </tbody>
    </table>
    <br/><br/>


  </div>  
</div>


<script >
    var x= document.getElementById("donhang");
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
