@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">
   <h3 class="text-info"><b><center>Thông tin nhập</center></b></h3>
 </div>

 <?php
 $STT=0;
 ?>

 <div class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-2" >Nhân viên:</label>
    <div class="col-sm-3">
      <label class="control-label">{{ Session::get('admin')->manv }}</label>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="option_provider">Nhà cung cấp:</label>
    <div class="col-sm-3">
      <select id ="combobox_provider" name="option_provider" class="form-control">
       @foreach($listProvider as $provider)
       <option value="{{$provider->id}}">{{$provider->ten}}</option>  
       @endforeach          
     </select>
   </div>
 </div>

 <div class="form-group">
  <label class="control-label col-sm-2" for="sanpham">Sản phẩm:</label>
  <div class="col-sm-3">
    <input type="text" class="form-control" id="sanpham_search" name="sanpham" placeholder="Nhập tên sản phẩm..." required="" aria-required="true">
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="number">Số lượng:</label>
  <div class="col-sm-3">
    <input type="number" class="form-control" id="number" name="number" placeholder="Nhập số lượng..." required="" aria-required="true">
  </div>
</div>
<div class="form-group">
  <label class="control-label col-sm-2" for="giaNhap">Giá nhập:</label>
  <div class="col-sm-3">
    <input type="number" class="form-control" id="giaNhap" name="giaNhap" placeholder="Nhập giá nhập..." required="" aria-required="true">
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="han_su_dung">Hạn sử dụng:</label>
  <div class="col-sm-3">
    <input type="date" class="form-control" id="han_su_dung" name="han_su_dung"  required="" aria-required="true">
  </div>
  <div class="col-sm-2">
    <button class="btn btn-success" onclick="addRow();" style="margin-left: 100px;">Thêm</button>
  </div>
  <div class="col-sm-2">
    <button class="btn btn-warning" onclick="refresh();" style="margin-left: 50px;">Làm mới</button>
  </div>
</div>

</div>


<br/>
<table class="table table-hover table-bordered" id="product" name="tableProduct">

  <thead>
    <tr>       
      <th><center>Mã SP</center></th>
      <th><center>Tên sản phẩm</center></th>
      <th><center>Giá nhập</center></th>
      <th><center>Số lượng</center></th>
      <th><center>Hạn sử dụng</center></th>
      <th><center>Tổng tiền</center></th>    
      <th><center>Xóa</center></th>    
    </tr>
  </thead>    
</table> 
<br/><br/>
<center><button class="btn btn-primary" onclick="addImportProduct()">Nhập hàng</button>
  <a href="{{ url('nhap-hang/in-hoa-don')}}" target="_blank" role="button" class="btn btn-primary" style="margin-left: 100px">In hóa đơn</a>

</center>
<br/><br/><br/><br/><br/><br/>
</div>

<script >
    var x= document.getElementById("nhapxuat");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[1].className="active";
</script>

</div>

<script >
  function addRow()
  { 
    var productCombobox = $("#sanpham_search").val();
    if(!productCombobox.includes("SP - ")){
      alert('Bạn cần nhập lại sản phẩm');
      return;
    }
    else{
      var list = productCombobox.split(" - ");
      var  input_number=document.getElementById('number').value;
      var input_expireDate=document.getElementById('han_su_dung').value;
      var giaNhap=document.getElementById('giaNhap').value;
      if(input_number==''){
        alert('Bạn chưa nhập số lượng');
        return;
      }
      else if(isNaN(input_number) ||input_number < 1){
        alert('Số lượng phải lớn hơn bằng 1');
        return;
      }

      else if(giaNhap==''){
        alert('Bạn chưa nhập giá nhập');
        return;
      }
      else if(isNaN(giaNhap) || giaNhap < 1){
        alert('Giá nhập phải lớn hơn bằng 1');
        return;
      }
      else if(input_expireDate==''){
        alert('Bạn chưa nhập hạn sử dụng');
        return;
      }

      var tong=input_number*giaNhap;

      var table=document.getElementById("product");
      var row=table.insertRow(-1);
      var id=row.insertCell(0);
      var name=row.insertCell(1);
      var cost=row.insertCell(2);
      var number=row.insertCell(3);
      var expireDate=row.insertCell(4);
      var sum=row.insertCell(5);
      var cell5=row.insertCell(6);

      id.innerHTML=list[1];
      id.style.textAlign = 'center';
      name.innerHTML=list[2];
      name.style.textAlign = 'center';
      cost.innerHTML= number_format(giaNhap);
      cost.style.textAlign = 'center';
      number.innerHTML=input_number;
      number.style.textAlign = 'center';
      expireDate.innerHTML=input_expireDate;
      expireDate.style.textAlign = 'center';
      sum.innerHTML=tong;
      sum.style.textAlign = 'center';
      cell5.style.textAlign = 'center';
      cell5.innerHTML = '<button class="btn btn-danger btn-xs" onclick="deleteCellItem(this);">Delete</button>';

      $('#number').val("");
      $('#giaNhap').val("");
      $('#sanpham_search').val("");
      $('#han_su_dung').val("dd/mm/yyyy");


    }
  }

</script>

<script >
    function deleteCellItem(r){
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("product").deleteRow(i);
    }
  </script>

<script >
  function addImportProduct(){   

    var table=document.getElementById("product");
    var numRow=table.rows.length;
    if(numRow<2){
      alert("Không có dữ liệu để nhập hàng");
    }
    else{
      var r = confirm("Bạn có chắc chắn không?");
      if(r = true){
        var dataSend=new Array(numRow);
      for (var i=0; i <numRow; i++){
        dataSend[i]=new Array(6);
      }
      for(var j=1;j<numRow;j++){
        var row=table.rows.item(j).cells;
        var numCell=row.length;
        for(var k=0;k<numCell;k++){
          var cellVal=row.item(k).innerHTML;
          dataSend[j][k]=cellVal;
        }
      }  
      var providerCombobox = document.getElementById("combobox_provider");
      var providerId = providerCombobox.options[providerCombobox.selectedIndex].value;

      $.ajax({     
       url:"{{url('add_import')}}",
       type: "GET",
       data:{'key': dataSend,
       'id': providerId},
       success:function(data){
        alert(data);
        $('#number').val("");
        $('#giaNhap').val("");
        $('#sanpham_search').val("");
        $('#han_su_dung').val("dd/mm/yyyy");
        
      }
    });
      }
      

    }
  }
</script>
<script>
  function refresh(){
    var table = document.getElementById('product');
        var length = table.rows.length;
        for (var i = 1; i < length; i++) {
          document.getElementById('product').deleteRow(1);
        }
  }
</script>
<script>
   $(document).ready(function() {
    src = "{{ route('searchajax_product') }}";
     $("#sanpham_search").autocomplete({
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


@endsection