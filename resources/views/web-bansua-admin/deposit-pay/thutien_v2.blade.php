
@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">
  <div class="main-right">
      <br/>
      <div class="col-md-8">
      <form action="{{ route('timkiem_thutien') }}" method="get" class="navbar-form">
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
    
    <br/><br/>
    
    <hr>
    
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
          <th><center>Cần thanh toán</center></th>
          <th><center>Người giao hàng</center></th>
        </tr>
      </thead>
      <tbody>
        @if(!empty($arr))
        <?php $STT=0 ?>
        @foreach($arr as $order)
        <tr>
          <td style="width: 10px"><center><label><input type="checkbox" onclick="handleClick(this);" name="donhang[]" id="donhang" class="checkbox" value="{{ $order->id }}--{{$arrTT[$STT]}}"></label></center></td>
          <td><center><?php echo ++$STT ?></center></td>
          <td style="width: 80px"><center><a href="#">{{ $order->id }}</a></center></td>
          <td style="width: 60px"><center><?php $date = date_create($order->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td><center>{{ $order->tenkh }}</center></td>
          <td><center>{{ $order->trangthai }}</center></td>
          <td style="width: 120px"><center><?php echo number_format($order->total_sales + $order->phiship).' ' ?><u>đ</u></center></td>
          <td style="width: 120px"><center><?php echo number_format($arrTT[$STT-1]).' ' ?><u>đ</u></center></td>
          <td style="width: 120px"><center>{{ $order->tennv }}</center></td>
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>
    <br>
      @if(count($arr))
          <table>
            <td><h4 class="text-info">Số tiền cần thanh toán:</h4></td>
            <td><label class="form-control" style="width: 150px; margin-left: 10px; font-size: 16px;
            font-family: 'Segoe UI Light','Helvetica Neue Light','Segoe UI','Helvetica Neue','Helvetica','Trebuchet MS','Verdana',sans-serif;" id="sotiencanthanhtoan">0</label></td>
            </table>

          <table>
          <br>
          <tr>
            <td><h4 class="text-info" id="myModalLabel">PT thanh toán</h4></td>
            <td><h4 class="text-info" id="myModalLabel" style="margin-left: 50px;">Ngày thu</h4></td>
            <td><h4 class="text-info" id="myModalLabel" style="margin-left: 50px;">Số tiền thanh toán</h4></td>
          </tr>
          <tr>
            <td>
                <select class="selectpicker form-control" style="width: 150px" id="option_selected">
                <option>Tiền mặt</option>
                <option>Chuyển khoản</option>
                </select>
              </td>
            <td><input type="date" id="ngaythu" class="form-control" style="margin-left: 50px; width: 160px"></td>
            <td><input type="number" id="sotienthu" min="0" class="form-control" style="margin-left: 50px; width: 170px"></td>
            <td><button class="btn btn-primary" onclick="saveDeposit(false);" style="margin-left: 100px">Tạo phiếu thu</button></td>
            <td><button class="btn btn-warning" onclick="saveDeposit(true);" style="margin-left: 50px">Tạo và in phiếu thu</button></td>
            </tr>
          </table>
          <br>
          

        @endif
    
    <br/><br/><br/><br/><br/><br/>
    

  </div>

</div>

<style>
.ui-autocomplete {
  z-index: 1050;
}
</style>

<script>
  function saveDeposit(hasPrint){
    var ngaythu = $("#ngaythu").val();
    var sotienthu = $("#sotienthu").val();
    var pttt = $("#option_selected").val();
    var label = document.getElementById('sotiencanthanhtoan').textContent;
    var sotiencan = parseInt(label);

    var dataSend = "";
    var checkboxes = document.getElementsByName("donhang[]");
    for (var i=0; i<checkboxes.length; i++) {
       if (checkboxes[i].checked) {
          
          dataSend += checkboxes[i].value+"++";
       }
    }
    
    if (sotiencan == 0) {
      alert('Chưa chọn hóa đơn cần thanh toán!')
    }
    else if(ngaythu == ""){
      alert('Chưa nhập ngày thu!');
    }
    else if (sotienthu == "") {
      alert('Chưa nhập số tiền!');
    }
    else if((isNaN(sotienthu) || sotienthu < 0)){
        alert("Số lượng phải lớn hơn hoặc bằng 0!");
        $('#sotienthu').val("");
    }
    else{
      $.ajax({
        url:'{{ url('tao-phieu-thu/')}}'+'/'+pttt+'/'+ngaythu+'/'+sotienthu,
        method: 'GET',
        data: {'key': dataSend},
        success:function(data){
          alert(data);
          location.reload();
        }
      });
    }
  }
</script>

<script>
  function handleClick(cb) {
    var list = cb.value.split("--");
    var label = document.getElementById('sotiencanthanhtoan');
    var a = label.textContent;
    var number;

    var data = a.split(",");
    var number_str = "";
    
    for(var i = 0; i < data.length; i++){
      number_str = number_str.concat(data[i]);
    }
    
    number = parseInt(number_str);

    // cong them
    if(cb.checked){
      number += parseInt(list[1]);
      label.textContent = number_format(number);
    }
    // tru
    else {
      number -= parseInt(list[1]);
      label.textContent = number_format(number);
    }
  }
</script>  


<script>
    $('document').ready(function(){
        $("#checkAll").click(function(){
             if ($(this).is(':checked')) {
                $(".checkbox").prop("checked", true);
                var checkboxes = document.getElementsByName("donhang[]");
                //alert(checkboxes.length);
                document.getElementById('sotiencanthanhtoan').textContent = "0";
                for (var i=0; i<checkboxes.length; i++) {
                   if (checkboxes[i].checked) {
                      handleClick(checkboxes[i]);
                   }
                }
             } else {
                $(".checkbox").prop("checked", false);
                document.getElementById('sotiencanthanhtoan').textContent = "0";
             }
        });
    });
</script>

<script >
    var x= document.getElementById("thuchi");
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