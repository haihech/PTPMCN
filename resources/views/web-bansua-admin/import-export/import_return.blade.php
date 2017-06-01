@extends('web-bansua-admin.index')
@section('content')


<div class="col-md-12">

  <div class="main-right">
   <h3 class="text-info"><b><center>Nhập hàng trả lại</center></b></h3>
     <div class="col-md-12">
                    
              <form action="{{ url('searchexportbykey') }}" method="get" class="navbar-form navbar-left">
                  <div class="input-group">
                      <div class="ui-widget">
                        <input type="text" id="search_export" name="search_export" class="form-control" placeholder="Nhập mã hóa đơn xuất..">                       
                      </div>
                            
                  </div>
                  <div class="input-group">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary" name="searchExport">
                  </div>
              </form>
        
      </div>
   <br/>   
  </div>
 <br/><br/>
  <?php
    $STT=0;
  ?>
 @if(Session::has('dataExportBill'))
 @foreach(Session::get('dataExportBill') as $export)
  <table name="myTable" style="margin-left: 50px">
    <tr >
      <td style="width: 150px"><label>Mã đơn hàng</label></td>
      <td> {{$export->id}}</td>     
    </tr>
    <tr>
      <td><label>Khách hàng</label></td>
      <td> {{Session::get('nameKH')}}</td>
      
    </tr>
     <tr>
      <td><label>Trạng thái</label></td>
      <td>{{$export->trangthai}}</td>
    </tr>
    <tr>
      <td><label>Người giao hàng</label></td>
      <td>{{$export->tennv}}</td>
    </tr>    
    <tr>
   
     </tr>      
  </table> 
 @endforeach
 @else
   <table name="myTable">
    <tr>
      <td><label>Mã đơn hàng hàng</label></td>       
     </tr>
    <tr>
      <td><label>Khách hàng</label></td>     
       </tr>
     <tr>
      <td><label>Trạng thái</label></td>      
    </tr>
         <tr>
      <td><label>Người giao hàng</label></td>     
    </tr>    
  </table> 


 @endif

 
<br/>
  <h4>Danh sách sản phẩm</h4><br/>
  <table class="table table-hover table-bordered" id="product" name="tableProduct">

    <thead>
      <tr>       
      <th><center>STT</center></th>
        <th><center>Mã SP</center></th>
        <th><center>Tên sản phẩm</center></th>
        <th><center>Số lượng</center></th>
        <th><center>Giá bán</center></th>
        <th><center>Hạn sử dụng</center></th>
        <th><center>Tổng tiền</c  enter></th>        
      </tr>
    </thead>  
    <body>
       <tr>
          @if(Session::has('dataDetailExport'))
          @foreach(Session::get('dataDetailExport') as $export)
          <td><center><?php echo ++$STT?></center></td>          
          <td><center>{{$export->sanpham_id}}</center></td>
          <td><center>{{$export->ten}}</center></td>
          <td><center>{{$export->soluong}}</center></td>
          <td><center><?php echo number_format($export->giaban).' ' ?><u>đ</u></center></td>
          <td><center>{{$export->hansudung}}</center></td>
          <td><center><?php echo number_format($export->soluong*$export->giaban).' ' ?><u>đ</u></center></td> 
         
          </tr>
           @endforeach
           @endif       
            
    </body>  
     </table> 
        <form action="{{ url('submit-turn-export') }}" method="get" class="formAddProvider" >  
        <div>
          
       @if(Session::has('dataExportBill'))
      @foreach(Session::get('dataExportBill') as $export)
       <input id="res_address" class="res_input" type="hidden" name="input_id_bill" value="{{$export->id}}" > 
       @endforeach
       @endif
         <select id ="combobox_export" name="option_export" class="form-control" style="width: 250px;">         
            <option >Giao hàng không thành công</option>  
            <option >Trả lại</option>           
         </select>    
     
    
        </div> 
  <center><button class="btn btn-primary" onclick="submitReturn()">Xác nhận</button></center>
  </form>
<br/><br/>
</div>


<script>
  $(document).ready(function() {
    src = "{{ route('searchajax_exporauto') }}";
    $("#search_export").autocomplete({
      
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

<script >
    var x= document.getElementById("nhapxuat");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[2].className="active";
</script>

<script >
  function submitReturn(){   
  var id_bill = document.getElementById("combobox_product");
}
</script>

@endsection