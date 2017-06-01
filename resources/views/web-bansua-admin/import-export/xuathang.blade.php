
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
              <div class="modal-dialog modal-lg" style="width: 70% " role="document">
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

                        <table id="myTable-{{ $order->id }}"  >
                          <tr>
                            <td>Sản phẩm:</td>
                            <td><input type="text" style="width: 260px; margin-left: 5px" name="nameproduct-{{ $order->id }}" id="nameproduct-{{ $order->id }}" class="form-control" placeholder="Nhập mã hoặc tên sản phẩm..."></td>
                            <td style="width: 0px;"></td>
                            <td><center>Hạn sử dụng:</center></td>
                            <td>
                              <select class="selectpicker form-control" style="width: 130px" name="option_selected_hansudung-{{ $order->id }}" id="option_selected_hansudung-{{ $order->id }}">
                                
                              </select>
                            </td>
                            <td></td>
                            <td>Tồn kho:<!-- <span style="width: 80px;padding: 10px 10px;margin-left: 10px; border: 1px solid #666; border-radius: 4px " id="tonkho-{{ $order->id }}"></span> --></td>
                            <td ><span class="form-control" style="width: 80px;" id="tonkho-{{ $order->id }}"></span></td>

                            <script>
                               $(document).ready(function() {
                                src = "{{ route('searchajax_product') }}";
                                 $("#nameproduct-{{ $order->id }}").autocomplete( {
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
                                    select: function (e, ui) {
                                      var key = ui.item.value;
                                      $.ajax({
                                        url:'{{URL::to('xuat-hang/hansudung-soluong')}}',
                                        method: "GET",
                                        data:{'key_get':key},
                                        success:function(data){
                                          if(data == 'Hết hàng'){
                                             alert(data);
                                             $("#nameproduct-{{ $order->id }}").val('');
                                          }
                                          else{
                                            $('#option_selected_hansudung-{{ $order->id }}').html(data[1]);
                                            $('#tonkho-{{ $order->id }}').html(data[0]);
                                          }
                                        }
                                      });

                                    },
                                   
                                  });

                              });
                            </script>
                            <script>
                              $(document).ready(function($){
                                  $('#option_selected_hansudung-{{ $order->id }}').change(function(){
                                      var selectpicker = $(this).val();
                                      var key = $('#nameproduct-{{ $order->id }}').val();
                                      var send_data = selectpicker + " ++ " + key;
                                      $.ajax({
                                            url:'{{URL::to('xuat-hang/soluong')}}',
                                            method: "GET",
                                            data:{'key': send_data},
                                            success:function(data){
                                            
                                              $('#tonkho-{{ $order->id }}').html(data);
                                            }
                                          });
                                  });
                              });
                            </script>
                            <script>
                              function addProductItem{{ $order->id }}(){
                                var available = $('#tonkho-{{ $order->id }}').html();
                                var a = parseInt(available);
        
                                var number = document.getElementById("numberproduct-{{ $order->id }}").value;
                                if(number == ''){
                                  alert("Bạn chưa nhập số lượng");
                                  return false;
                                }
                                if(isNaN(number) || number < 1){
                                  alert("Số lượng phải lớn hơn hoặc bằng 1");
                                  document.getElementById("numberproduct-{{ $order->id }}").value = "";
                                  return false;
                                }
                                if(number > a){
                                  alert("Số lượng phải nhỏ hơn hoặc bằng số tồn kho");
                                  document.getElementById("numberproduct-{{ $order->id }}").value = "";
                                  return false;
                                }
                                
                                  var hsd = $('#option_selected_hansudung-{{ $order->id }}').val();
                                  var sp = $('#nameproduct-{{ $order->id }}').val();
                                  if(sp == ''){
                                    alert('Bạn chưa chọn sản phẩm');
                                    return false;
                                  }
                                  if(hsd == ''){
                                    alert('Bạn chưa chọn hạn sử dụng');
                                    return false;
                                  }
                                  
                                    var splitted = sp.split("-", 3);
                              
                                    var table = document.getElementById("myTable1-{{ $order->id }}");
                                    var row = table.insertRow(-1);
                                    var cell1 = row.insertCell(0);
                                    var cell2 = row.insertCell(1);
                                    var cell3 = row.insertCell(2);
                                    var cell4 = row.insertCell(3);
                                    var cell5 = row.insertCell(4);

                                    cell1.innerHTML = splitted[1];
                                    cell1.style.textAlign = 'center';
                                    cell2.innerHTML = splitted[2];
                                    cell2.style.textAlign = 'center';
                                    cell3.innerHTML = number;
                                    cell3.style.textAlign = 'center';
                                    cell4.innerHTML = hsd;
                                    cell4.style.textAlign = 'center';
                                    cell5.style.textAlign = 'center';
                                    cell5.innerHTML = '<button class="btn btn-danger btn-xs" onclick="deleteCellItem{{ $order->id }}(this);">Delete</button>';
                                    
                                    $('#nameproduct-{{ $order->id }}').val('');
                                    $('#option_selected_hansudung-{{ $order->id }}').val('');
                                    document.getElementById("numberproduct-{{ $order->id }}").value = "";
                                    $('#tonkho-{{ $order->id }}').html('');
                                    // document.getElementById("tonkho-{{ $order->id }}").value = "";
   
                                  
                                
                              }
                          </script>
                          <script >
                            function deleteCellItem{{ $order->id }}(r){
                              var i = r.parentNode.parentNode.rowIndex;
                              document.getElementById("myTable1-{{ $order->id }}").deleteRow(i);
                            }
                          </script>



                          </tr>
                          <tr style="height: 20px"></tr>
                          <tr>
                            <td style="width: 120px; padding-left: 50px;">Số lượng:</td>
                            <td><input type="number" style="width: 150px" id="numberproduct-{{ $order->id }}" name="numberproduct-{{ $order->id }}" class="form-control" min="0" value="" ></td>
                            
                            <td><button class="btn btn-success" id="addProductItem" name="addProductItem" onclick="addProductItem{{ $order->id }}();">Chọn</button></td>
               

                          </tr>

                        </table>


                        <br/><br/><br/>

                        <table id="myTable1-{{ $order->id }}" class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              
                              <th><center>Mã SP</center></th>
                              <th><center>Tên sản phẩm</center></th>
                              <th><center>Số lượng</center></th>
                              <th><center>Hạn sử dụng</center></th>
                              <th><center>Xóa</center></th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>

                        <br/><br/><br/>
                      </div>

                      
                      <center><button class="btn btn-primary" onclick="saveExport{{$order->id}}({{$order->id}})" >Lưu</button>
                      <a href="{{ url('xuat-hang/in-hoa-don', ['id'=>$order->id]) }}" target="_blank" role="button" class="btn btn-primary" style="margin-left: 30px">In hóa đơn</a>
                      <a href="{{ url('xuat-hang/dong')  }}" class="btn btn-primary"  style="margin-left: 30px">Đóng</a>
                      </center>
                      
                      <br/><br/><br/>
                    
                      <script>
                        function saveExport{{$order->id}}(id){
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
                                  for(var j = 0; j < cellLength - 1; j++){
                                        var cellVal = oCells.item(j).innerHTML;

                                        dataSend += cellVal + " ++ ";
                                     }
                                }
                                dataSend +=id;
                                
                                $.ajax({

                                    url:'{{URL::to('xuat-hang/luu-hoa-don-xuat')}}',
                                    method: "GET",
                                    data:{'key_save': dataSend},
                                    success:function(data){
                                      
                                        alert(data)

                                      
                                      // var table = document.getElementById('myTable1-{{ $order->id }}');
                                      // var length = table.rows.length;
                                      // for(var i = 1; i < length; i++){
                                      //   document.getElementById("myTable1-{{ $order->id }}").deleteRow(1);
                                      // }
                                      
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