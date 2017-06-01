@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">
    <br/><br/>
      <form class="navbar-form navbar-left" method="get" action="{{ route('tim_kiem_thu_chi') }}">
        <div class=" form-horizontal">
        <div class="form-group">
          
              <label class="control-label col-xs-2" for="option_selected">Chọn loại</label>
              <div class="col-sm-3">
                <select class="selectpicker form-control" name="option_selected">
                @foreach($arrOption as $option)
                <option>{{ $option }}</option>
                @endforeach
                </select></div>
          
            <div class="input-group-btn">
            <input type="text" id="search_key" name="search_key" class="form-control search-field" placeholder="Nhập mã phiếu..." style="width: 200px;">
            
              <input type="submit" class="btn btn-success" value="Tìm kiếm" role="button" name="search">
            </div>
           </div>
        </div>
      </form>
  </div>

  <br/><br/><br/><br/>
  
  @if($deposit)
  <table class="table table-hover table-bordered">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã phiếu thu</center></th>
        <th><center>PT thanh toán</center></th>
        <th><center>Ngày thu</center></th>
        <th><center>Tổng tiền thu</center></th>
        <th><center>In phiếu thu</center></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $STT=0;
      ?>
      
      @foreach($listDeposit as $order)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td style="width: 150px"><a href="" data-toggle="modal" data-target="#myModalDeposit-{{$order->id}}"><center>#{{$order->id}}</center></a>

            <!-- Modal -->
            <div class="modal fade" id="myModalDeposit-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-info" id="myModalLabel">PHIẾU THU</h3>
                  </div>
                  <div class="modal-body">
                    <div class="thongtinnguoimua">
                      <div>Mã phiếu thu: {{ $order->id }}</div>
                      <div>Phương thức thanh toán: {{ $order->phuongthucthanhtoan }}</div>
                      <div>Ngày thu: <?php $date = date_create($order->ngaythu); echo date_format($date,"d/m/Y"); ?></div>

                    </div>
                    <hr>
                    <div class="giohang">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Mã hóa đơn xuất</center></th>
                            <th><center>Số tiền cần thu</center></th>
                            <th><center>Số tiền đã thu</center></th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arrDeposit[$order->id] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->hoadonxuat_id }}</center></td>
                            <td><center><?php echo number_format($detail->total_sales + $detail->phiship).' ' ?><u>đ</u></center></td>
                            <td><center><?php echo number_format($detail->sotienthu).' ' ?><u>đ</u></center></td>
                            
                          @endforeach
                          <tr>
                            <td colspan="5" align="right" style="font-size: 1.2em;">Tổng số tiền thu: <?php echo number_format($order->total_deposit).' ' ?><u>đ</u></td>
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
        <td><center>{{ $order->phuongthucthanhtoan}}</center></td>
        <td><center><?php $date = date_create($order->ngaythu); echo date_format($date,"d/m/Y"); ?></center></td>
        <td style="width: 200px"><center><?php echo number_format($order->total_deposit).' ' ?><u>đ</u></center></td>
        <td><center><button type="button" class="btn btn-warning btn-sm">In phiếu thu</button></center></td>
        
    </tr>
    @endforeach

    

  </tbody>

</table>
@elseif($pay)

  <table class="table table-hover table-bordered">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã phiếu thu</center></th>
        <th><center>Nhà cung cấp</center></th>
        <th><center>PT thanh toán</center></th>
        <th><center>Ngày chi</center></th>
        <th><center>Tổng tiền chi</center></th>
        <th><center>In phiếu chi</center></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $STT=0;
      ?>
      
      @foreach($listPay as $order)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td style="width: 150px"><a href="" data-toggle="modal" data-target="#myModalPay-{{$order->id}}"><center>#{{$order->id}}</center></a>

            <!-- Modal -->
            <div class="modal fade" id="myModalPay-{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-info" id="myModalLabel">PHIẾU CHI</h3>
                  </div>
                  <div class="modal-body">
                    <div class="thongtinnguoimua">
                      <div>Mã phiếu chi: {{ $order->id }}</div>
                      <div>Nhà cung cấp: {{ $order->ncc }}</div>
                      <div>Phương thức thanh toán: {{ $order->phuongthucthanhtoan }}</div>
                      <div>Ngày chi: <?php $date = date_create($order->ngaychi); echo date_format($date,"d/m/Y"); ?></div>
                     
                    </div>
                    <hr>
                    <div class="giohang">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Mã hóa đơn nhập</center></th>
                            <th><center>Số tiền cần chi</center></th>
                            <th><center>Số tiền đã chi</center></th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arrPay[$order->id] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->hoadonnhap_id }}</center></td>
                            <td><center><?php echo number_format($detail->total_sales).' ' ?><u>đ</u></center></td>
                            <td><center><?php echo number_format($detail->sotienchi).' ' ?><u>đ</u></center></td>
                            
                          @endforeach
                          <tr>
                            <td colspan="5" align="right" style="font-size: 1.2em;">Tổng số tiền chi: <?php echo number_format($order->total_pay).' ' ?><u>đ</u></td>
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
        <td><center>{{ $order->ncc }}</center></td>
        <td><center>{{ $order->phuongthucthanhtoan}}</center></td>
        <td><center><?php $date = date_create($order->ngaychi); echo date_format($date,"d/m/Y"); ?></center></td>
        <td style="width: 200px"><center><?php echo number_format($order->total_pay).' ' ?><u>đ</u></center></td>
        <td><center><button type="button" class="btn btn-warning btn-sm">In phiếu chi</button></center></td>
    </tr>
    @endforeach

    

  </tbody>

</table>

@endif
<br/><br/><br/><br/>
</div>


<script >
    var x= document.getElementById("thuchi");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[2].className="active";
</script>


@endsection