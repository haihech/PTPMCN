
@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12 affix-content">
  <div class="main-right">
      <br/>
      <div class="col-md-8">
      <form action="{{ route('timkiemgiaohang') }}" method="get" class="navbar-form">
      <div class="col-md-6">
          <table>
            <tr>
              <td><p>
                <select class="selectpicker form-control" style="width: 250px" name="option_selected">
                <option>Chọn người giao hàng</option>
                @foreach($giaohang as $gh)
                  <option>{{ $gh->ten }} - {{ $gh->manv }}</option>
                @endforeach
                </select>
              </p></td>
            </tr>

          </table>
        </div>

        <div class="input-group">
          <input type="submit" class="btn" name="timkiemdonhang" value="Tìm kiếm" id="icon-search" style="text-indent: 17px">
        </div>
      </form>
    </div>
    
    <br/><br/><br/>
    <?php $STT=0 ?>
    @if(!empty($orders))
    <center><h4 class="text-info">Danh sách đơn hàng</h4></center>
    <hr>
     
     <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
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
        
        @foreach($orders as $order)
        <tr>
          <td><center><?php echo ++$STT ?></center></td>

          <td style="width: 80px"><a href="" data-toggle="modal" data-target="#myModal-{{ $order->id}}"><center>#{{ $order->id}}</center></a>

            <!-- Modal -->
            <div class="modal fade" id="myModal-{{ $order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" style="width: 65% " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Danh sách đặt hàng</h4>
                  </div>

                  <div class="modal-body">
                      <table class="table table-bordered table-hover" id="table-{{ $order->id }}">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Mã SP</center></th>
                            <th><center>Tên sản phẩm</center></th>
                            <th><center>Số lượng</center></th>
                            <th><center>Đơn giá</center></th>
                            <th><center>Thành tiền</center></th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(!empty($arr))
                          <?php $stt=0 ?>
                          @foreach($arr[$STT] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->sanpham_id }}</center></td>
                            <td><center>{{ $detail->name }}</center></td>
                            <td><center>{{ $detail->soluong }}</center></td>
                            <td><center><?php echo number_format($detail->giaban).' ' ?><u>đ</u></center></td>
                            <td><center><?php echo number_format($detail->giaban * $detail->soluong).' ' ?><u>đ</u></center></td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>

                      </table>



                      <br/>
                      <h4>Tạo hóa đơn xuất</h4>
                      <hr>
                      
                      <div class="col-md-12">

                        <table id="myTable1-{{ $order->id }}" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th><center>STT</center></th>
                              <th><center>Mã SP</center></th>
                              <th><center>Tên sản phẩm</center></th>
                              <th><center>Số lượng</center></th>
                              <th><center>Hạn sử dụng</center></th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(!empty($arrAuto))
                            <?php $st=0 ?>
                            @foreach($arrAuto[$STT] as $detail)
                            <tr>
                              <td><center><?php echo ++$st ?></center></td>
                              <td><center><?php echo $detail['id'] ?></center></td>
                              <td><center><?php echo $detail['name'] ?></center></td>
                              <td><center><?php echo $detail['number'] ?></center></td>
                              <td><center><?php $date = date_create($detail['hansudung']); echo date_format($date,"d/m/Y"); ?></center></td>
                    
                            </tr>
                            @endforeach
                            @endif
                          </tbody>
                        </table>

                        <br/><br/><br/>
                      </div>

                      
                      <center><button class="btn btn-primary" onclick="saveExport{{$order->id}}({{$order->id}}, false)" >Lưu hóa đơn</button>
                      <button class="btn btn-warning btn-sam" style="margin-left: 50px" onclick="saveExport{{$order->id}}({{$order->id}}, true)" >Lưu và In hóa đơn</button>
                      <!-- <a href="{{ url('xuat-hang/in-hoa-don', ['id'=>$order->id]) }}" target="_blank" role="button" class="btn btn-warning btn-sam" style="margin-left: 50px">In hóa đơn</a> -->
                      </center>
                      
                      <br/><br/><br/>
                    
                      <script>
                        function saveExport{{$order->id}}(id, print){
                          var oTable = document.getElementById('myTable1-{{ $order->id }}');
                          var rowLength = oTable.rows.length;
                          
                          if(rowLength <= 1){
                            alert('Chưa có dữ liệu tại bảng hóa đơn xuất!');
                          }
                          else{
                            
                            var r = confirm("Bạn có chắc chắn muốn lưu không!");
                            if (r == true) {
                                var dataSend = "";
                                for (var i = 1; i < rowLength; i++){
                                  var oCells = oTable.rows.item(i).cells;

                                  var cellLength = oCells.length;
                                  for(var j = 1; j < cellLength; j++){
                                        var cellVal = oCells.item(j).innerHTML;
                                        var list = cellVal.split(">");
                                        var data = list[1].split("<");
                                        dataSend += data[0] + " ++ ";
                                     }
                                }
                                dataSend +=id;
                                
                                $.ajax({
                                    //url:'{{ url('xuat-hang/luu-hoa-don-xuat/')}}'+'/'+id,
                                    url:'{{ url('xuat-hang/luu-hoa-don-xuat') }}',
                                    async: false, // không chặn tab mới bật lên trong chrome
                                    method: "GET",
                                    data:{'key_save': dataSend},
                                    success:function(data){
                                      alert(data);
                                      location.reload();
                                      if(print){
                                        window.open('http://localhost/ptpmcn/public/xuat-hang/in-hoa-don/'+id,'_blank');
                                      }
                                        
                                    }
                              });
                            }
                           
                          }
                          
                        }
                      </script>
                  </div>

                </div>
              </div>
            </div>

          </td>
          <td style="width: 80px"><center><?php $data = date_create($order->created_at); echo date_format($data, "d/m/Y"); ?><center></td>
          <td><center>{{ $order->tenkh }}</center></td>
          <td><center>{{ $order->trangthai}}</center></td>
          <td><center>{{ $order->diachigiaohang }}</center></td>
          <td style="width: 120px"><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
          <td style="width: 100px"><center>@if (!empty($name)) {{$name}}  @endif</center></td>
          
        </tr>

        @endforeach
        
      </tbody>
    </table>
    @endif
    <br/><br/><br/><br/>
  </div>

</div>  

<style>
.ui-autocomplete {
  z-index: 1050;
}
</style>

<script >
    var x= document.getElementById("nhapxuat");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection