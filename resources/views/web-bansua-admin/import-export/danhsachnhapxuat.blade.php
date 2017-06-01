@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">
    <br/><br/>
      <form class="navbar-form navbar-left" method="get" action="{{ route('tim_kiem_nhap_xuat') }}">
        <div class=" form-horizontal">
        <div class="form-group">
          
              <label class="control-label col-xs-2" for="option_selected">Chọn loại</label>
              <div class="col-sm-3">
                <select class="selectpicker form-control" name="option_selected">
                @foreach($arrOption as $option)
                <option>{{$option}}</option>
                @endforeach
                </select></div>
          
            <div class="input-group-btn">
            <input type="text" id="search_product" name="search_order" class="form-control search-field" placeholder="Nhập mã hóa đơn..." style="width: 200px;">
            
              <input type="submit" class="btn btn-success" value="Tìm kiếm" role="button" name="searchOrder">
            </div>
           </div>
        </div>
      </form>
  </div>

  <br/><br/><br/><br/>
  
  @if($export)
  <table class="table table-hover table-bordered">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã hóa đơn xuất</center></th>
        <th><center>Khách hàng</center></th>
        <th><center>Trạng thái</center></th>
        <th><center>PT thanh toán</center></th>
        <th><center>Giao hàng</center></th>
        <th><center>Tổng tiền</center></th>
        <th><center>In hóa đơn</center></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $STT=0;
      ?>
      
      @foreach($listExport as $order)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td style="width: 150px"><a href="" data-toggle="modal" data-target="#myModalExport-{{$order->id}}"><center>#{{$order->id}}</center></a>

            <!-- Modal -->
            <div class="modal fade" id="myModalExport-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-info" id="myModalLabel">HÓA ĐƠN XUẤT</h3>
                  </div>
                  <div class="modal-body">
                    <div class="thongtinnguoimua">
                      <h4>1.Thông tin khách hàng:</h4>
                      <div>Họ tên: {{ $order->tenkh }}</div>
                      <div>Điện thoại: {{ $order->sdt }}</div>
                      <div>Email: {{ $order->email }}</div>
                      <div>Địa chỉ giao hàng: {{ $order->diachigiaohang }}</div>
                      @if($order->note != NULL)
                      <div>Ghi chú: {{ $order->note }}</div>
                      @endif
                      <div>Phương thức thanh toán: {{ $order->phuongthucthanhtoan }}</div>

                    </div>
                    <hr>
                    <div class="giohang">
                      <h4>2. Danh sách sản phẩm</h4>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Tên sản phẩm</center></th>
                            <th><center>Số lượng</center></th>
                            <th><center>Hạn sử dụng</center></th>
                            <th><center>Đơn giá</center></th>
                            <th><center>Thành tiền</center></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arrExport[$order->id] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->name }}</center></td>
                            <td><center>{{ $detail->soluong }}</center></td>
                            <td><center><?php $date = date_create($detail->hansudung); echo date_format($date,"d/m/Y"); ?></center></td>
                            <td style="width: 100px"><center><?php echo number_format($detail->giaban).' ' ?><u>đ</u></center></td>
                            <td style="width: 120px"><center><?php echo number_format($detail->giaban * $detail->soluong ).' ' ?><u>đ</u></center></td>
                          </tr>
                          @endforeach
                          <tr>
                            <td colspan="6" align="right" style="font-size: 1.2em;">Tổng tiền: <?php echo number_format($order->total_sales).' ' ?><u>đ</u></td>
                          </tr>
                          <tr>
                            <td colspan="6" align="right" style="font-size: 1.2em;">Phí ship: <?php echo number_format($order->phiship).' ' ?><u>đ</u></td>
                          </tr>
                          <tr>
                            <td colspan="6" align="right" style="font-size: 1.2em;">Số tiền cần thanh toán: <?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></td>
                          </tr>
                        </tbody>

                      </table>
                      
                      <br/><br/><br/>
                    </div>

                  </div>

                </div>
              </div>
            </div>

          </td>
        <td><center>{{ $order->tenkh }}</center></td>
        <td><center>{{ $order->trangthai }}</center></td>
        <td><center>{{ $order->phuongthucthanhtoan}}</center></td>
        <td><center>{{ $order->giaohang }}</center></td>
        <td style="width: 150px"><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
        <td><center><a href="{{ url('xuat-hang/in-hoa-don', ['id'=>$order->id]) }}" target="_blank" role="button" class="btn btn-warning btn-sm">In hóa đơn</a></center></td>
        
    </tr>
    @endforeach

    

  </tbody>

</table>
@elseif($import)

  <table class="table table-hover table-bordered">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã hóa đơn nhập</center></th>
        <th><center>Ngày nhập</center></th>
        <th><center>Nhà cung cấp</center></th>
        <th><center>Tổng tiền</center></th>
        <th><center>In hóa đơn</center></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $STT=0;
      ?>
      
      @foreach($listImport as $order)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td style="width: 150px"><a href="" data-toggle="modal" data-target="#myModalImport-{{$order->id}}"><center>#{{$order->id}}</center></a>

            <!-- Modal -->
            <div class="modal fade" id="myModalImport-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-info" id="myModalLabel">HÓA ĐƠN NHẬP</h3>
                  </div>
                  <div class="modal-body">
                    <div class="thongtinnguoimua">
                      <h4>1.Thông tin hóa đơn:</h4>
                      <div>Mã hóa đơn: {{ $order->id }}</div>
                      <div>Ngày nhập: <?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></div>
                      <div>Nhà cung cấp: {{ $order->ten }}</div>
                     
                    </div>
                    <hr>
                    <div class="giohang">
                      <h4>2. Danh sách sản phẩm</h4>
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Tên sản phẩm</center></th>
                            <th><center>Số lượng</center></th>
                            <th><center>Giá nhập</center></th>
                            <th><center>Thành tiền</center></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arrImport[$order->id] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->name }}</center></td>
                            <td><center>{{ $detail->soluong }}</center></td>
                            <td><center><?php echo number_format($detail->gianhap).' ' ?><u>đ</u></center></td>
                            <td><center><?php echo number_format($detail->gianhap * $detail->soluong ).' ' ?><u>đ</u></center></td>
                          </tr>
                          @endforeach
                            <tr>
                            <td colspan="5" align="right" style="font-size: 1.2em;">Số tiền cần thanh toán: <?php echo number_format($order->total_sales).' ' ?><u>đ</u></td>
                          </tr>
                        </tbody>

                      </table>
                      
                      <br/><br/><br/>
                    </div>

                  </div>

                </div>
              </div>
            </div>

          </td>
        <td style="width: 150px"><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
        <td><center>{{ $order->ten}}</center></td>
        <td style="width: 150px"><center><?php echo number_format($order->total_sales).' ' ?><u>đ</u></center></td>
        <td><center><a href="{{ url('nhap-hang/in-hoa-don', ['id'=>$order->id]) }}" target="_blank" role="button" class="btn btn-warning btn-sm">In hóa đơn</a></center></td>
    </tr>
    @endforeach

    

  </tbody>

</table>

@endif
<br/><br/><br/><br/>
</div>


<script >
    var x= document.getElementById("nhapxuat");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[3].className="active";
</script>


@endsection