@extends('web-bansua-admin.index')
@section('content')
<div class="col-md-11">
  <div class="main-right">
    <br/>
    <div class="form-inline">
        <div class="form-group">
          <h3 class="text-info">Danh sách thương hiệu </h3>

        </div>
        <div class="form-group" style="margin-left: 100px">
         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalAddTrademark">
           Thêm thương hiệu
        </button>
      </div>
    </div>

    <br/>


    <div class="modal fade" id="myModalAddTrademark" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Thêm thương hiệu</h4>
        </div>
    <form action="{{ url('add-trademark') }}" method="get" class="form-horizontal" >
        <div class="modal-body">
        <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Tên thương hiệu:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="res_address" name="input_name_trademark" placeholder="Nhập tên nhà cung cấp" required="" aria-required="true">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Quốc gia:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="res_address" name="input_nation_trademark" placeholder="Nhập quốc gia" required="" aria-required="true">
              </div>
            </div>     

        </div>        
        <div class="modal-footer">
         <input type="submit" name="btn-add" value="Thêm" class="btn btn-primary">
         <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left: 50px;">Đóng</button> </div>
        </form>
                 
          
        </div>
 
      </div>
      
    </div>
  </div>
                  

    <table class="table table-striped table-bordered" id="myTable" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã thương hiệu</center></th>
          <th><center>Tên thương hiệu</center></th>
          <th><center>Quốc gia</center></th>     
          <th><center>Thay đổi</center></th>     
        </tr>
      </thead>
      <tbody>
      <?php
      $STT=0;
      ?>
               
        @foreach($listTrademark as $trademark)
        <tr>
          <th><center><?php echo ++$STT?></center></th>          
          <td><center><center>{{$trademark->id}}</center></td>
          <td><center>{{$trademark->ten}}</center></td>
          <td><center>{{$trademark->nuoc}}</center></td>         
           <td>
            <center>
             <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModalChangeTrademark-{{$trademark->id}}">
                  Thay đổi
            </button>            
                     
            </center>

      <div class="modal fade" id="myModalChangeTrademark-{{$trademark->id}}" role="dialog">
      <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" ><center>Thông tin thương hiệu</center></h4>
        </div>
        <div class="modal-body">
    <form action="{{ url('change-trademark') }}" method="get" class="form-horizontal" >
        
        <input id="res_address" class="res_input" type="hidden" name="input_id_trademark" value="{{$trademark->id}}" > 
       <div class="form-group">
              <label class="control-label col-sm-3" for="password_them">Tên thương hiệu:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="res_address" name="input_name_trademark"  required="" aria-required="true" value="{{$trademark->ten}}" >
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="password_them">Quốc gia:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="res_address" name="input_nation_trademark"  required="" aria-required="true" value="{{$trademark->nuoc}}">
              </div>
            </div>     

               
        <div class="modal-footer">
         <input type="submit" name="btn-add" value="Cập nhật" class="btn btn-primary">
        
          <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left: 50px;">Đóng</button></div>        
          </form>
        </div>
 
      </div>
      
    </div>
           </td>
         
        </tr>
       
        @endforeach
        
      </tbody>
    </table>
    <br/><br/><br/><br/><br/><br/>
    
  </div>  

<script >
    var x= document.getElementById("sanpham");
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

