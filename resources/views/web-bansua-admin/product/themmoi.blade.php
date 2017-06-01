@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-9">

  <div class="main-right">
   <h3><b>Phương thức nhập</b></h3>
   <br/>
   <form action="{{ route('import_excel') }}" method="post" enctype="multipart/form-data">
     <h4><b>Nhập dữ liệu từ file excel</b></h4>
     <input type="file" name="uploadFileExcel" id="uploadFileExcel"  accept="xlsx/*">
     <br/>
     <div>
       <input  type="submit" name="import_excel" class="btn btn-success" value="Lưu">
       <input  type="submit" name="cancel_import_excel" class="btn btn-warning" value="Hủy" style="margin-left: 30px">
       {{ csrf_field() }}
     </div>
   </form>
 </div>

 <br/><br/>

 <h4><b>Thêm mới</b></h4>

 <form action="{{ route('themmoisanpham') }}" method="post" enctype="multipart/form-data">
  <table class="table">
    <tr>
      <td><label>Tên sản phẩm:</label></td>
      <td><input style="width: 500px" type="text" class="form-control" name="name_product" value=""  required="" aria-required="true" ></td>
    </tr>
    <tr>
      <td><label>Giá:</label></td>
      <td><input style="width: 200px" type="number" class="form-control" name="giaban_product" value=""  required="" aria-required="true" min="1000"></td>
    </tr>
    <tr>
      <td><label>Giảm giá:</label></td>
      <td><input style="width: 200px" type="number" class="form-control" name="discount_product" value=""  required="" aria-required="true"" min="0"></td>
    </tr>
    <tr>
      <td><label>Thương hiệu:</label></td>
      <td><p>
        <select style="width: 300px" class="selectpicker form-control" name="option_thuonghieu">
          @foreach($thuonghieu as $gh)
          <option>{{ $gh->ten }}</option>
          @endforeach
        </select>
      </p></td>
    </tr>
    <tr>
      <td><label>Nhóm tuổi:</label></td>
      <td><p>
        <select style="width: 300px" class="selectpicker form-control" name="option_nhomtuoi">
          @foreach($nhomtuoi as $gh)
          <option>{{ $gh->tuoi }}</option>
          @endforeach
        </select>
      </p></td>
    </tr>

  </table>
  <br/>
  <label for="mota_product_add">Mô tả sản phẩm</label>
  <span>
    <textarea name="mota_product_add" id="mota_product_add" class="textbox"></textarea>
    <script type="text/javascript">
      CKEDITOR.replace('mota_product_add');
    </script>
  </span><br/>
  <br/>

  <label>Chèn ảnh</label>
  <input type="file" name="uploadFileImg" id="uploadFileImg" accept="image/*">
  <br/><br/>
  <div><center>
    <input type="submit" class="btn btn-primary" name="them_moi" id="them_moi" value="Thêm mới">
    {{ csrf_field() }}
    <a href="{{ route('themmoi') }}" name="huy_them_moi" class="btn btn-warning" style="margin-left: 50px">Hủy</a>
    
  </div></center>
  <br/><br/><br/><br/>
</form>

<br/><br/>
</div>

<script >
    var x= document.getElementById("sanpham");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[3].className="active";
</script>

@endsection