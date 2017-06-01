@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">

    <div class="col-md-5">
      <h3 class="text-info">Tạo phiếu thu</h3>
    </div>

    <br/>
    <br/> <br/>

    <div class="form-horizontal">
      <div class="form-group">
        <label class="control-label col-sm-2" for="search_customer">Khách hàng:</label>
        <div class="col-sm-4" >
          <input type="text" id="search_customer" name="search_customer" class="form-control search-field" placeholder="Nhập tên khách hàng...">

        </div>

       
      </div>


      <div class="form-group">
        <label class="control-label col-sm-2" for="option_selected_thanhtoan">PT thanh toán:</label>
        <div class="col-sm-3">
          <select style="width: 160px" class="selectpicker form-control" name="option_selected_thanhtoan" id="option_selected_thanhtoan">
            <option value="Tiền mặt">Tiền mặt</option>
            <option value="Chuyển khoản">Chuyển khoản</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="ngay">Ngày:</label>
        <div class="col-sm-3">
          <input id="ngay" class="form-control" size="30" type="date" name="ngay" >   
        </div>
      </div>

    </div>
  </div>
  <br/>
  
    <div class="form-group form-horizontal">
        <label class="control-label col-xs-2" for="search_order">Đơn hàng:</label>
        <div class="col-sm-4" >
          <input type="text" id="search_order" name="search_order" class="form-control search-field" placeholder="Nhập mã hóa đơn hoặc tên khách hàng...">
          
        </div>
        <label class="control-label col-xs-1" for="tien">Số tiền:</label>
        <div class="col-sm-2">
          <input type="number" name="tien" id="tien" class="form-control" min="1">
        </div>

        <div style="margin-left: 830px;">
          <button class=" btn btn-primary" onclick="addOrderItem();">Thêm</button>
          
          <button class="btn btn-success" onclick="refresh();" style="margin-left: 40px;">Làm mới</button>
        
        </div>
         

      </div>
  
  <br/>
  <table class="table table-hover table-bordered" id="myTable">
   <thead>
        <tr>
          <th><center>Ngày</center></th>
          <th><center>Mã đơn hàng</center></th>
          <th><center>Mã khách hàng</center></th>
          <th><center>Trạng thái</center></th>
          <th><center>Giao hàng</center></th>
          <th><center>PT thanh toán</center></th>
          <th><center>Số tiền cần thanh toán</center></th>
          <th><center>Số tiền thanh toán</center></th>
          <th><center>Xóa</center></th>
        </tr>
    </thead>

    <tbody>
      
    </tbody>

  </table>
  <br/><br/>
  <center><button class="btn btn-primary" onclick="saveDeposit();" >Lưu</button>
      <a href="#" role="button" class="btn btn-primary" style="margin-left: 50px; ">In phiếu thu</a>
  </center>
  
  <br/><br/><br/><br/><br/><br/>

</div>
<script>
  function saveDeposit(){
    var table = document.getElementById("myTable");
    var rowLength = table.rows.length;
                          
      if(rowLength <= 1){
        alert('Chưa có dữ liệu trong bảng!');
      }
      else{
        
        var r = confirm("Bạn có chắc chắn muốn lưu không!");
        if (r == true) {
            var dataSend = "";
            for (var i = 1; i < rowLength; i++){
              var oCells = table.rows.item(i).cells;

              var cellLength = oCells.length;
              for(var j = 0; j < cellLength - 1; j++){
                    var cellVal = oCells.item(j).innerHTML;

                    dataSend += cellVal + " ++ ";
                 }
            }
            $.ajax({

                url:'{{URL::to('tao-phieu-thu')}}',
                method: "GET",
                data:{'key_save': dataSend},
                success:function(data){
                  
                  alert(data)

                  for(var i = 1; i < rowLength; i++){
                    document.getElementById("myTable").deleteRow(1);
                  }
                  $("#search_customer").val("");
                  $("#option_selected_thanhtoan").val("Tiền mặt");
                  $("#ngay").val("dd/mm/yyyy");
                  $('#search_order').val("");
                  $('#tien').val("");
                  
                }
          });
        }
       
      }
  }
</script>

<script>
  $(document).ready(function() {
       $("#search_customer").autocomplete( {
          
          source: function(request, response) {
              $.ajax({
                  url: "{{ route('search_customer') }}",
                  dataType: "json",
                  data: {
                      term : request.term
                  },
                  success: function(data) {
                      response(data);
                  }
              });
          },
          min_length: 2,
         
        });

    });
      
</script>

<script>
   $(document).ready(function() {
    
     $("#search_order").autocomplete({

        source: function(request, response) {
            $.ajax({
                url: "{{ route('search_order_ajax') }}",
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        min_length: 2,
       
    });
});
</script>
<script>
  function refresh(){
    $("#search_customer").val("");
    $("#option_selected_thanhtoan").val("Tiền mặt");
    $("#ngay").val("dd/mm/yyyy");
    $('#search_order').val("");
    $('#tien').val("");
  }
</script>

<script>
    function addOrderItem(){
      var check = true;
      var khachhang = $('#search_customer').val();
      var ngay = $('#ngay').val();
      var donhang = $('#search_order').val();
      var tien = $('#tien').val();
      var pttt = $('#option_selected_thanhtoan').val();
      if(khachhang == ''){
        check = false;
        alert("Bạn chưa nhập khách hàng");
      }
      if(check && !khachhang.includes("Mã -- ")) {
        check = false;
        alert("Bạn cần nhập lại tên khách hàng");
        $('#search_customer').val("");
      }
      if (check && ngay == "") {
        check = false;
        alert("Bạn chưa chọn ngày")
      }

      if (check && donhang == ""){
        check = false;
        alert("Bạn chưa nhập đơn hàng");
      }
      if(check && ! donhang.includes("Mã ĐH -- ")) {
        check = false;
        alert("Bạn cần nhập lại đơn hàng");
        $('#search_order').val("");
      }

      if (check && tien == "") {
        check = false;
        alert("Bạn chưa nhập số tiền");
      }
      else if(check && (isNaN(tien) || tien < 1)){
        check = false;
        alert("Số lượng phải lớn hơn hoặc bằng 1");
        $('#tien').val("");
      }

      if(check){

        var listOrder = donhang.split(" -- ");
        var listCustomer = khachhang.split(" -- ");
        var table = document.getElementById("myTable");
        var row = table.insertRow(-1);

        var cell0 = row.insertCell(0);
        var cell1 = row.insertCell(1);
        var cell2 = row.insertCell(2);
        var cell3 = row.insertCell(3);
        var cell4 = row.insertCell(4);
        var cell5 = row.insertCell(5);
        var cell6 = row.insertCell(6);
        var cell7 = row.insertCell(7);
        var cell8 = row.insertCell(8);
        
        cell0.innerHTML = ngay;
        cell0.style.textAlign = 'center';
        cell1.innerHTML = listOrder[1];
        cell1.style.textAlign = 'center';
        cell2.innerHTML = listCustomer[1];
        cell2.style.textAlign = 'center';
        cell3.innerHTML = listOrder[3];
        cell3.style.textAlign = 'center';
        cell4.innerHTML = listOrder[4];
        cell4.style.textAlign = 'center';
        cell5.innerHTML = pttt;
        cell5.style.textAlign = 'center';
        cell6.innerHTML = number_format(listOrder[5]);
        cell6.style.textAlign = 'center';
        cell7.innerHTML = number_format(tien);
        cell7.style.textAlign = 'center';
        cell8.innerHTML = '<button class="btn btn-danger btn-xs" onclick="deleteCellItem(this);">Delete</button>';
        cell8.style.textAlign = 'center';
        
        $('#search_order').val("");
        $('#tien').val("");
   
      }

    }
  </script>

  <script >
    function deleteCellItem(r){
      var i = r.parentNode.parentNode.rowIndex;
      document.getElementById("myTable").deleteRow(i);
    }
  </script>
<script >
    var x= document.getElementById("thuchi");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[0].className="active";
</script>


@endsection
