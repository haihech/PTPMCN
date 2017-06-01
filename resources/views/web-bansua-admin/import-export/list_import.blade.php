@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">

    <div class="timkiem">
      <br/>
      <form action="{{route('searchproductbykey')}}" method="get" class="navbar-form navbar-left">        
        <div class="col-md-5">
          <div class="input-group search-bar">
            <input type="text" id="search_import" name="search_import" class="form-control search-field" placeholder="Nhập mã hoặc tên sữa...">
            <div class="input-group-btn">
              <input type="submit" class="btn btn-success" value="Tìm kiếm" role="button" name="searchProduct">
            </div>
          </div>

        </div>
      </form>

      <form action="{{ route('addImport') }}" method="get" class="navbar-form navbar-left">
        <div class="input-group">
          <input type="submit" class="btn btn-primary" value="Nhập mới">
        </div>
      </form>

    </div>
  </div>

  <br/><br/><br/><br/>
  <table class="table table-hover table-bordered">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã SP</center></th>
        <th><center>Tên sản phẩm</center></th>
        <th><center>Giá ban đầu</center></th>
        <th><center>Giá bán</center></th>
        <th><center>Thương hiệu</center></th>
        <th><center>Nhóm tuổi</center></th>
        <th><center>Ảnh</center></th>
        <th><center>Cập nhật</center></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $STT=0;
      ?>
      @if(Session::has('search_product_by_key'))
      @foreach(Session::get('search_product_by_key') as $product)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td><center>{{ $product->id }}</center></td>
        <td><center>{{ $product->ten }}</center></td>
        <td><center>{{ $product->giaban }}<u>đ</u></center></td>
        <td><center>{{ $product->giaban - $product->discount }}<u>đ</u></center></td>
        <td><center>{{ $product->tenthuonghieu }}</center></td>
        <td><center>{{ $product->tuoi }}</center></td>
         <td><center>{{ $product->anh }}</center></td>
        <td><center>
          <button type="button" style="font-size: 12px" class="btn btn-primary" data-toggle="modal" data-target="#my-{{$product->id}}">
            Edit
          </button>
        </center>
        <!-- Modal -->
        <div class="modal fade" id="my-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
                  </div>
                  <div class="modal-body">
                <form action="{{ url('danh-muc-san-pham/cap-nhat', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
                  
                  <table>
                    <tr>
                      <td><label>Mã sản phẩm:</label></td>
                      <td class="form-control" style="width: 100px" ><center><label>{{ $product->id }}</label></center></td>
                    </tr>
                    <tr>
                      <td><label>Tên sản phẩm:</label></td>
                      <td><input type="text" class="form-control" name="name_product" value="{{ $product->ten }}"  required="" aria-required="true"></td>
                    </tr>
                    <tr>
                      <td><label>Giá:</label></td>
                      <td><input type="number" class="form-control" name="giaban_product" value="{{ $product->giaban }}" aria-required="true" min="1000"  required=""></td>
                    </tr>
                    <tr>
                      <td><label>Giảm giá:</label></td>
                      <td><input type="number" class="form-control" name="discount_product" value="{{ $product->discount }}" aria-required="true" min="0" max=""  required=""></td>
                    </tr>

                    <tr>
                      <td><label>Thương hiệu:</label></td>
                      <td><p>
                        <select style="width: 150px" class="selectpicker form-control" name="option_thuonghieu_{{ $product->id }}">
                        <option>{{$product->tenthuonghieu}}</option>
                        @foreach($thuonghieu as $gh)
                        <option>{{ $gh->ten }}</option>
                        @endforeach
                      </select>
                      </p></td>
                    </tr>
                    <tr>
                      <td><label>Nhóm tuổi:</label></td>
                      <td><p>
                        <select style="width: 250px" class="selectpicker form-control" name="option_nhomtuoi_{{ $product->id }}">
                        <option>{{$product->tuoi}}</option>
                        @foreach($nhomtuoi as $gh)
                        <option>{{ $gh->tuoi }}</option>
                        @endforeach
                      </select>
                      </p></td>
                    </tr>

                  </table>
                  <br/><br/>
                  <label for="mota_product">Mô tả sản phẩm</label>
                    <span>
                      <textarea name="mota_product_{{ $product->id }}" id="mota_product_{{ $product->id }}" class="textbox">{!! $product->mota !!}</textarea>
                      <script type="text/javascript">
                        CKEDITOR.replace('mota_product_{{ $product->id }}');
                      </script>
                    </span><br/>
                  <br/>

                  <label>Chèn ảnh</label>
                  <input type="file" name="uploadFile" id="uploadFile" accept="image/*">

                  <div>
                  <br/><br/>
                  <center><input type="submit" class="btn btn-primary" name="cap-nhat" id="cap-nhat" value="Cập nhật sản phẩm"></center>

                  <script>
                    $("#cap-nhat").on("click", function{
                      confirm("Bạn có chắc chắn muốn thay đổi không?");
                    });
                  </script>

                  {{ csrf_field() }}
                  <br/><br/><br/><br/>
                  </div>
                </form>


              </div>

            </div>
          </div>
        </div>

      </td>
    </tr>
    @endforeach
    @else
    <!-- <tr><td><center>Khong so du lieu de hien thi</center></td></tr> -->
    @endif

  </tbody>

</table>
<br/><br/><br/><br/><br/>
</div>


<script>
  $(document).ready(function() {
    src = "{{ route('searchajax_product') }}";
    $("#search_product").autocomplete({
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
    x.getElementsByTagName("a")[3].className="active";
</script>


@endsection