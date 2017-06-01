@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">
    <br/>
      <form class="navbar-form navbar-left" method="post" action="{{ route('thong_ke_san_pham') }}">
        <div class=" form-horizontal">
          <div class="form-group">
              <label class="control-label col-xs-2" for="option_selected">Chọn loại:</label>
              <div class="col-xs-2">
                <select class="selectpicker form-control" name="option_selected_avaiable" id="option_selected_avaiable">
                  @foreach($arrAvaiable as $value)
                  <option>{{$value}}</option>
                  @endforeach
                </select>
              </div>

              <label class="control-label col-xs-2" for="option_selected">Hạn sử dụng trong:</label>
              <div class="col-xs-4">
                <select style="width: 100px" class="selectpicker form-control" name="option_selected_time" id="option_selected_time">
                @if(!empty($arrOption))
                  @foreach($arrOption as $value)
                  <option>{{$value}}</option>
                  @endforeach
                @endif
                </select>
                <select style="width: 80px" class="selectpicker form-control" name="option_time" id="option_time">
                @if(!empty($arrOptionTime))
                  @foreach($arrOptionTime as $value)
                  <option>{{$value}}</option>
                  @endforeach
                  @endif
                </select>
              </div>
          
            <div class="input-group-btn">
              <input type="submit" class="btn btn-success" value="Thống kê" role="button" name="searchProduct">
            </div>
            {{ csrf_field() }}

           </div>

      </form>
      <!-- <br/><br/>
      <form class="navbar-form navbar-left" method="post" action="{{ route('thong_ke_san_pham_ban_chay') }}">
        <div class=" form-horizontal">
          <div class="form-group">
              <label class="control-label col-xs-2" >Số lượng:</label>
              <div class="col-xs-2">
                <select class="selectpicker form-control" name="number_option">
                  <option>1</option>
                  <option>5</option>
                  <option>10</option>
                  <option>20</option>
                  <option>30</option>
                  <option>50</option>
                </select>
              </div>

              <label class="control-label col-xs-2" for="option_selected">Thời gian:</label>
              <div class="col-xs-4">
                <select style="width: 100px" class="selectpicker form-control" name="time1" id="time1">
                  <option>Ngày</option>
                  <option>Tháng</option>
                  <option>Năm</option>
                </select>
                <select style="width: 80px" class="selectpicker form-control" name="time2" id="time2">
                @if(!empty($arrOptionTime))
                  @foreach($arrOptionTime as $value)
                  <option>{{$value}}</option>
                  @endforeach
                  @endif
                </select>
              </div>

            <div class="input-group-btn">
              <input type="submit" class="btn btn-primary" value="Thống kê sản phẩm bán chạy" role="button" name="productBest">
            </div>
            {{ csrf_field() }}

           </div>

      </form> -->
  </div>

  <br/><br/><br/><br/>
  @if(!empty($listProduct))
    <table class="table table-hover table-bordered table-striped" id="myTable">
  
    <thead>
      <tr>
        <th><center>Mã sản phẩm</center></th>
        <th><center>Tên sản phẩm</center></th>
        <th><center>Giá</center></th>
        <th><center>Giảm giá</center></th>
        <th><center>Thương hiệu</center></th>
        <th><center>Nhóm tuổi</center></th>
      </tr>
    </thead>
    <tbody>
      @foreach($listProduct as $product)
      <tr>
        <td><center>{{ $product->id }}</center></td>
        <td><center>{{ $product->ten }}</center></td>
        <td><center><?php echo number_format($product->giaban).' ' ?><u>đ</u></center></td>
        <td><center><?php echo number_format($product->discount).' ' ?><u>đ</u></center></td>
        <td><center>{{ $product->tenthuonghieu }}</center></td>
        <td><center>{{ $product->tuoi }}</center></td>
      </tr>
      @endforeach
      <!-- <tr><td><center>Khong so du lieu de hien thi</center></td></tr> -->
   
    </tbody>
  
  </table>
   @endif

   @if(!empty($list))
    <table class="table table-hover table-bordered table-striped" id="myTable">
  
    <thead>
      <tr>
        <th><center>Mã sản phẩm</center></th>
        <th><center>Tên sản phẩm</center></th>
        <th><center>Giá</center></th>
        <th><center>Giảm giá</center></th>
        <th><center>Thương hiệu</center></th>
        <th><center>Nhóm tuổi</center></th>
        <th><center>Tồn kho</center></th>
      </tr>
    </thead>
    <tbody>
      @foreach($list as $product)
      <tr>
        <td><center>{{ $product->id }}</center></td>
        <td><center>{{ $product->ten }}</center></td>
        <td><center><?php echo number_format($product->giaban).' ' ?><u>đ</u></center></td>
        <td><center><?php echo number_format($product->discount).' ' ?><u>đ</u></center></td>
        <td><center>{{ $product->tenthuonghieu }}</center></td>
        <td><center>{{ $product->tuoi }}</center></td>
        <td><center>{{ $number[$product->id] }}</center></td>
      </tr>
      @endforeach
      <!-- <tr><td><center>Khong so du lieu de hien thi</center></td></tr> -->
   
    </tbody>
  
  </table>
   @endif
  
<br/><br/><br/><br/>
</div>

<script>
  $(document).ready(function($){
      $('#option_selected_avaiable').change(function(){
          var selected = $(this).val();
          if(selected == "Hết hàng"){
            $('#option_selected_time').html('');
            $('#option_time').html('');
          }
          else if(selected == "Tồn kho"){
            $('#option_selected_time').html('<option>Ngày</option><option>Tháng</option><option>Năm</option>');
            var data = "";  
            for(var i = 1; i < 32; i++){
                if(i < 10)
                  data += '<option>0'+i+'</option>';
                else
                  data += '<option>'+i+'</option>';
            }
            $('#option_time').html(data);
          }
      });
  });
</script>



<script>
  $(document).ready(function($){
    $('#option_selected_time').change(function(){
      var selected = $(this).val();
      if(selected == "Ngày"){
        var data = "";  
          for(var i = 1; i < 32; i++){
              if(i < 10)
                data += '<option>0'+i+'</option>';
              else
                data += '<option>'+i+'</option>';
          }
          $('#option_time').html(data);
      }

      else if (selected == "Tháng") {
          var data = "";  
          for(var i = 1; i < 13; i++){
              data += '<option>'+i+'</option>';
          }
          $('#option_time').html(data);
      }   

      else if (selected == "Năm") {
        var data = "";  
          for(var i = 1; i < 6; i++){
              data += '<option>'+i+'</option>';
          }
          $('#option_time').html(data);
      }
    });
  });
  
</script>

<script>
  $(document).ready(function($){
    $('#time1').change(function(){
      var selected = $(this).val();
      if(selected == "Ngày"){
        var data = "";  
          for(var i = 1; i < 32; i++){
              if(i < 10)
                data += '<option>0'+i+'</option>';
              else
                data += '<option>'+i+'</option>';
          }
          $('#time2').html(data);
      }

      else if (selected == "Tháng") {
          var data = "";  
          for(var i = 1; i < 13; i++){
              data += '<option>'+i+'</option>';
          }
          $('#time2').html(data);
      }   

      else if (selected == "Năm") {
        var data = "";  
          for(var i = 1; i < 6; i++){
              data += '<option>'+i+'</option>';
          }
          $('#time2').html(data);
      }
    });
  });
  
</script>

<script >
    var x= document.getElementById("thongke");
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