@extends('web-bansua-admin.index')
@section('content')
<div class="col-md-12">
  <div class="main-right">

      
    <br/>
      <div class="form-inline">
      <div class="form-group">
        <h3 class="text-info">Danh sách nhà cung cấp</h3>
      </div>
      
        
        <div class="form-group" style="margin-left: 100px">
         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalAddProvider">
          Thêm nhà cung cấp
        </button>
      </div>
    </div>
  
  <br/><br/><br/>

  <!--  Modall -->
  <div class="modal fade" id="myModalAddProvider" role="dialog">
    <div class="modal-dialog" role="document">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >Thêm nhà cung cấp</h4>
        </div>
        <div class="modal-body">
        <form action="{{ url('add-provider') }}" method="get" class="form-horizontal" >

            
            <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Tên nhà cung cấp:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="res_address" name="input_name_provider" placeholder="Nhập tên nhà cung cấp" required="" aria-required="true">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Địa chỉ:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="res_address" name="input_address_provider" placeholder="Nhập địa chỉ" required="" aria-required="true">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Số điện thoại:</label>
              <div class="col-sm-7">
                <input class="form-control" id="res_address" name="input_phoneNumber_provider" placeholder="Nhập số điện thoại" type="tel"  maxlength="11" size="30"  required=""  pattern="^\d{8,11}" aria-required="true">
              </div>
            </div>

              <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Email:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="res_address" name="input_email_provider" placeholder="Nhập email" required="" aria-required="true">
              </div>
            </div>

               <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Fax:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="res_address" name="input_fax_provider" placeholder="Nhập fax" required="" aria-required="true">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Số tài khoản:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="res_address" name="input_accountNumber_provider" placeholder="Nhập số tài khoản" required="" aria-required="true">
              </div>
            </div>           

            <div class="form-group">
              <label class="control-label col-sm-4" for="password_them">Mã số thuế:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="res_address" name="input_taxNumber_provider" placeholder="Nhập mã số thuế" required="" aria-required="true">
              </div>
            </div>    

                  
          <div class="modal-footer">
           <input type="submit" name="btn-add" value="Thêm" class="btn btn-primary">
           <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left: 50px;">Đóng</button> </div>
           <br/><br/>
         </form>
         </div>
               

       </div>

     </div>

   </div>
 </div>


 <!-- endModal -->
 <table class="table table-hover table-bordered table-striped" id="myTable">
  <thead>
    <tr>
      <th><center>STT</center></th>
      <th><center>Mã NCC</center></th>
      <th><center>Tên nhà cung cấp</center></th>
      <th><center>Địa chỉ</center></th>
      <th><center>Số điện thoại</center></th>
      <th><center>Email</center></th>
      <th><center>Fax</center></th>     
      <th><center>Số tài khoản</center></th>     
      <th><center>Mã số thuế</center></th>     
      <th><center>Thay đổi</center></th>     
    </tr>
  </thead>
  <tbody>
    <?php
    $STT=0;
    ?>               
    @foreach($listProvider as $provider)
    <tr>
      <th><center><?php echo ++$STT?></center></th>          
      <td><center><center>{{$provider->id}}</center></td>
      <td><center>{{$provider->ten}}</center></td>
      <td><center>{{$provider->diachi}}</center></td>
      <td><center>{{$provider->sdt}}</center></td>
      <td><center>{{$provider->email}}</center></td>
      <td><center>{{$provider->fax}}</center></td>      
      <td><center>{{$provider->sotk}}</center></td>   
      <td><center>{{$provider->masothue}}</center></td>              
      <td>
        <center>
         <button type="button" style="font-size: 12px" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalChangeData-{{$provider->id}}">
          Edit
        </button>

      </center>
      <!--  Modall -->
        <div class="modal fade" id="myModalChangeData-{{$provider->id}}" role="dialog">
          <div class="modal-dialog" role="document">

           <!-- Modal content-->
           <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" ><center>Thông tin nhà cung cấp</center></h4>
            </div>
            <div class="modal-body">
            <form action="{{ url('change-provider') }}" method="get" class="form-horizontal" >
              
              <input id="res_address" class="res_input" type="hidden" name="input_id_provider" value="{{$provider->id}}" > 

                <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Tên nhà cung cấp:</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="res_address" name="input_name_provider" required="" aria-required="true" value="{{$provider->ten}}" >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Địa chỉ:</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="res_address" name="input_address_provider" placeholder="Nhập địa chỉ" required="" aria-required="true" value="{{$provider->diachi}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Số điện thoại:</label>
                    <div class="col-sm-7">
                      <input class="form-control" id="res_address" name="input_phoneNumber_provider" placeholder="Nhập số điện thoại" type="tel"  maxlength="11" size="30"  required=""  pattern="^\d{8,11}" aria-required="true" value="{{$provider->sdt}}">
                    </div>
                  </div>

                    <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Email:</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="res_address" name="input_email_provider" placeholder="Nhập email" required="" aria-required="true" value="{{$provider->email}}">
                    </div>
                  </div>

                     <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Fax:</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="res_address" name="input_fax_provider" placeholder="Nhập fax" required="" aria-required="true" value="{{$provider->fax}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Số tài khoản:</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="res_address" name="input_accountNumber_provider" placeholder="Nhập số tài khoản" required="" aria-required="true" value="{{$provider->sotk}}">
                    </div>
                  </div>           

                  <div class="form-group">
                    <label class="control-label col-sm-4" for="password_them">Mã số thuế:</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="res_address" name="input_taxNumber_provider" placeholder="Nhập mã số thuế" required="" aria-required="true" value="{{$provider->masothue}}">
                    </div>
                  </div>

                      
              <div class="modal-footer">
               <input type="submit" name="btn-add" value="Cập nhật" class="btn btn-primary">
               <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left: 50px;">Đóng</button></div>
             </form>
             </div>
                    
           </div>

         </div>

       </div>
    </td>         
  </tr>    
  
 <!--     End Modal -->
 @endforeach        
</tbody>
</table>
<br/><br/><br/><br/><br/><br/>

</div>  
</div>

<script >
    var x= document.getElementById("nhacungcap");
    x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection

