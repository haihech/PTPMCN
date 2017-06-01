@extends('web-bansua-admin.index')
@section('content')
<div class="col-md-10">
  <div class="main-right">
  <br/>

    <div class="form-inline">
      <div class="form-group">
       <h3 class="text-info">Danh sách nhóm tuổi</h3>

      </div>
      <div class="form-group" style="margin-left: 100px">
       <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalAddAgeGroup">
         Thêm nhóm tuổi
       </button>
     </div>
   </div>

   <br/><br/>
   <!--  Modall -->
   <div class="modal fade" id="myModalAddAgeGroup" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Thêm nhóm tuổi</h4>
        </div>
        <form action="{{ url('add-age-group') }}" method="get" class="form-horizontal" >
          <div class="modal-body">

            <div class="form-group">
              <label class="control-label col-sm-4" for="input_from">Từ:</label>
              <div class="col-sm-3">
                <input type="number" min="0" max="200" value="0" class="form-control" id="input_from" name="input_from" required="" aria-required="true">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="input_to">Đến:</label>
              <div class="col-sm-3">
                <input type="number" min="0" max="200" value="1" class="form-control" id="input_to" name="input_to" required="" aria-required="true">
              </div>
            </div>    

          </div>        
          <div class="modal-footer">
           <input type="submit" name="btn-add" value="Thêm" class="btn btn-primary">
         </form>
         <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left: 50px;">Đóng</button>       

       </div>

     </div>

   </div>
 </div>


 <!-- endModal -->
 <table class="table table-hover table-bordered table-striped" id="myTable">
  <thead>
    <tr>
      <th><center>STT</center></th>
      <th><center>Mã nhóm tuổi</center></th>
      <th><center>Nhóm tuổi</center></th>           
      <th><center>Thay đổi</center></th>     
    </tr>
  </thead>
  <tbody>
    <?php
    $STT=0;
    ?>

    @foreach($listAgeGroup as $age)
    <tr>
      <th><center><?php echo ++$STT?></center></th>          
      <td><center><center>{{$age->id}}</center></td>
      <td><center>{{$age->tuoi}}</center></td>              
      <td>
        <center>
         <button type="button" style="font-size: 12px" class="btn btn-warning" data-toggle="modal" data-target="#myModalChangeAgeGroup-{{$age->id}}">
          Thay đổi
        </button>            

      </center>
      <!--  Modall -->
      <div class="modal fade" id="myModalChangeAgeGroup-{{$age->id}}" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" >Thông tin nhóm tuổi</h4>
            </div>
            <form action="{{ url('change-age-group') }}" method="get" class="form-horizontal" >
              <div class="modal-body">
                <input id="res_address" class="res_input" type="hidden" name="input_id_age_group" value="{{$age->id}}" >  
                <div class="form-group">
                  <label class="control-label col-sm-4" for="input_from">Từ:</label>
                  <div class="col-sm-3">
                    <input type="number" min="0" max="200" value="{{ $arr[$age->id][0] }}" class="form-control" id="input_from" name="input_from" required="" aria-required="true">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-4" for="input_to">Đến:</label>
                  <div class="col-sm-3">
                  <input type="number" min="0" max="200" value="{{ $arr[$age->id][1] }}" class="form-control" id="input_to" name="input_to" required="" aria-required="true">
                  </div>
                </div>   

              </div>        
              <div class="modal-footer">
               <input type="submit" name="btn-add" value="Cập nhật" class="btn btn-primary">
             </form>
             <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left: 50px;">Đóng</button>       

           </div>

         </div>

       </div>
     </td>

   </tr>
   
   
   
   <!-- endModal -->
   @endforeach
   
 </tbody>
</table>
<br/><br/>


</div>  
</div>
<script >
    var x= document.getElementById("sanpham");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[2].className="active";
</script>


<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>
@endsection

