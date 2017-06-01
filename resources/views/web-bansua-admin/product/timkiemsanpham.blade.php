@extends('web-bansua-admin.index')
@section('content')

<div class="col-md-12">
  <div class="main-right">
    <div class="timkiem">
      <br/>
      <div class="col-md-6">
        <form action="{{route('search_product')}}" method="get">

          <div class="input-group search-bar">
            <input type="text" id="search_product" name="search_product" class="form-control search-field" placeholder="Nhập mã sản phẩm hoặc tên sản phẩm...">
            <div class="input-group-btn">
              <input type="submit" class="btn btn-primary" value="Tìm kiếm!" role="button">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <br/><br/><br/><br/>
  
    @if(Session::has('search_product'))
    <table class="table table-hover table-bordered">
  
    <thead>
      <tr>
        <th><center>Mã sản phẩm</center></th>
        <th><center>Tên sản phẩm</center></th>
        <th><center>Giá ban đầu</center></th>
        <th><center>Giá bán</center></th>
        <th><center>Thương hiệu</center></th>
        <th><center>Nhóm tuổi</center></th>
        <th><center>Tồn kho</center></th>
        <th><center>Đang đặt</center></th>
      </tr>
    </thead>
    <tbody>
      @foreach(Session::get('search_product') as $product)
      <tr>
        <td><center>#{{ $product->id }}</center></td>
        <td><center>{{ $product->ten }}</center></td>
        <td><center><?php echo number_format($product->giaban).' ' ?><u>đ</u></center></td>
        <td><center><?php echo number_format($product->giaban - $product->discount).' ' ?><u>đ</u></center></td>
        <td><center>{{ $product->tenthuonghieu }}</center></td>
        <td><center>{{ $product->tuoi }}</center></td>
        <td><center>{{ Session::has('count_avaiable') ? Session::get('count_avaiable') : '0' }}</center></td>
        <td><center>{{ Session::has('count_ordered') ? Session::get('count_ordered') : '0' }}</center></td>
      </tr>
      @endforeach
      <!-- <tr><td><center>Khong so du lieu de hien thi</center></td></tr> -->
   
    </tbody>
  
  </table>
   @endif
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
    var x= document.getElementById("sanpham");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[0].className="active";
</script>

@endsection