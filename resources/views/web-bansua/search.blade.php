@extends('web-bansua.index')
@section('css')
  <link href="{{ asset('web-bansua/style.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
      <span><br/></span>
      <div class="col-md-10">
      <div class="main-content">
          <div class="panel bg-product">
            <div class="panel-heading"><center><b>Kết quả tìm kiếm cho "{{ $keySearch }}"</b></center></div>
            
            <div class="panel-body bg-product-list">
                <div class="product-list" id = "product-list">
                @if($products)
                @foreach ($products as $sp)
                    <div class="col-md-3 product-detail">
                       <a href="{{ url('products', [$sp->id]) }}">
                       <div class="hinhanh">
                       <img src="{{ asset('images/'.$sp->anh) }}" class="img-responsive" alt="Responsive image">
                       </div>
                       </a>
                       <div class="ten">
                         {{$sp->ten}}
                       </div>
                       <div class="gia">
                         {{$sp->giaban}}<u>đ</u>
                       </div>
                       <div>
                         <a href="{{ url('add-to-cart', [$sp->id])}}" class="btn btn-success pull-right" role="button">Mua ngay</a>
                       </div>

                    </div>
                @endforeach
                @else
                  <div ><center><b>Mời bạn nhập từ khóa khác để tìm kiếm.</b></center></div>
                @endif
                </div>
            </div>
            
          </div>
      </div>
    </div>
      <div class="col-md-2">
          <div class="content-right"></div>
      </div>
    </div>
    </div>
    <div class="back_top"> <a class="btn-top" href="javascript:void(0);" title="Top" style="display: inline;"></a> 
    </div>
    @endsection
