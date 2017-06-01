@extends('web-bansua.index')
@section('css')
  <link href="{{ asset('web-bansua/style.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="main">
            <div class="col-md-3">
                <div class="content-left">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-list"></span> Danh mục sản phẩm</a></li>
                        <li role="presentation"><a href="#"><img src="images/cat_1.jpg" class="" alt="Responsive image">Sua phap</a></li>
                        <li role="presentation"><a href="#"><img src="images/cat_2.jpg" class="" alt="Responsive image">XO- I AM MOTHER</a></li>
                        <li role="presentation"><a href="#"><img src="images/cat_3.jpg" class="" alt="Responsive image">ABBOTT</a></li>
                        <li role="presentation"><a href="#"><img src="images/cat_4.jpg" class="" alt="Responsive image">BIOMIL-LADYMIL</a></li>
                        <li role="presentation"><a href="#"><img src="images/cat_1.jpg" class="" alt="Responsive image">GLICO_MEIJ</a></li>
                        <li role="presentation"><a href="#"><img src="images/cat_2.jpg" class="" alt="Responsive image">MORINAGA</a></li>
                      </ul>
                    </div>
                    <span><br/></span>
                    <span><br/></span>
                    <span><br/></span>
                    <span><br/></span>
                    <img src="images/banner_trai1.jpg" class="img-responsive">
                    <span><br/></span>
                    <img src="images/banner_trai2.jpg" class="img-responsive">
                    <span><br/></span>
                    <img src="images/banner-trai3.jpg" class="img-responsive">                  
                </div>
          </div>
            <div class="col-md-9">
              <div class="slide">
                  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                      <div class="item active">
                        <img class="banner" src="images/banner1.jpg" alt="banner1">
                      </div>
                      <div class="item">
                        <img class="banner" src="images/banner2.jpg" alt="banner2">
                      </div>
                      <div class="item">
                        <img class="banner" src="images/banner3.jpg" alt="banner2">
                      </div>
                      <div class="item">
                        <img class="banner" src="images/banner4.jpg" alt="banner2">
                      </div>
                      <div class="item">
                        <img class="banner" src="images/banner5.jpg" alt="banner2">
                      </div>
                    </div>
                      <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>            
              </div>
              <span><br/></span>

              <div class="main-content">
                  <div class="panel bg-product">
                    <div class="panel-heading">Product</div>
                    <div class="panel-body bg-product-list">
                        <div class="product-list" id = "product-list">
                        @foreach ($sanpham as $sp)
                            <div class="col-md-3 product-detail">
                               <a href="{{ url('products', [$sp->id]) }}">
                               <div class="hinhanh">
                               <img src="images/{{$sp->anh}}" class="img-responsive" alt="Responsive image">
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
