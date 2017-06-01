<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Sua</title>
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<header>
        <nav class="navbar navbar-default bg-header">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img alt="Brand" src="images/brand.png"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav menu">
                  <li><a href="{{ route('web-bansua.home') }}"><span class="glyphicon glyphicon-home"></span> Trang chủ</a></li>
                  <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Đơn hàng</a></li>
                  <li><a href="#"><i class="fa fa-cube" aria-hidden="true"></i> Giới thiệu</a></li>
              </ul>
              <form class="navbar-form navbar-left">
                  <div class="input-group">
                      <div class="ui-widget">
                        <input type="text" id="search" class="form-control" placeholder="Tìm kiếm...">
                        <div class="dropdown-menu" id="productList"></div>
                      </div>
                            
                  </div>
                  <div class="input-group">
                    <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i>
                          </button>
                        </span>  
                  </div>
              </form>
              <ul class="nav navbar-nav navbar-right menu">
                <li><a href="{{ route('web-bansua.shoppingCart') }}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Giỏ hàng (<span id="count_item">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>)<br /> <span class="cart-price">{{ Session::has('cart') ? Session::get('cart')->totalPrice.'đ' : '0đ' }}</span></a></li>

                @if(!Session::has('account'))
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tài khoản<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('web-bansua/signin')}}" class="btn" role="button">Đăng nhập</a></li>
                        <li><a href="{{ url('web-bansua/signup') }}" class="btn" role="button">Đăng ký</a></li>
                           
                    </ul>
                  </li>
                  @else
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Session::get('account')->ten}}<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="#" class="btn" role="button">Thông tin tài khoản</a></li>
                          <li><a href="#" class="btn" role="button">Kiểm tra đơn hàng</a></li>
                          <li class="divider" role="separator"></li>
                          <li><a href="{{ url('web-bansua/logout') }}" class="btn" role="button">Đăng xuất</a></li>
                             
                      </ul>
                    </li>
                  @endif

              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </header>
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
                                      
                </div>
            </div>
            <div class="col-md-9">
              <div class="main-content">
                  <div class="panel panel-primary">
                    <div class="panel-heading">Sua phap</div>
                    <div class="panel-body bg-product-list">
                        <div class="product-list">
                            <div class="col-md-3 product-detail">
                               <div class="hinhanh">
                                 <img src="images/suaphap_1.jpg" class="img-responsive" alt="Responsive image">
                               </div>
                               <div class="ten">
                                 Sữa Celia Expert mama 400g 
                               </div>
                               <div class="gia">
                                 182.000 VND
                               </div>
                               <div class="chitiet">
                                <a href="">Xem chi tiet</a>
                               </div>

                            </div>
                            <div class="col-md-3 product-detail">
                               <div class="hinhanh">
                                 <img src="images/suaphap_2.jpg" class="img-responsive" alt="Responsive image">
                               </div>
                               <div class="ten">
                                 Sữa Celia Expert Số 1 - 900g (0-6 tháng)
                               </div>
                               <div class="gia">
                                 389.000 VND
                               </div>
                               <div class="chitiet">
                                <a href="">Xem chi tiet</a>
                               </div>

                            </div>
                            <div class="col-md-3 product-detail">
                               <div class="hinhanh">
                                 <img src="images/suaphap_3.jpg" class="img-responsive" alt="Responsive image">
                               </div>
                               <div class="ten">
                                 Sữa Celia Expert Số 2 - 900g (tạm hết)
                               </div>
                               <div class="gia">
                                 385.000 VND
                               </div>
                               <div class="chitiet">
                                <a href="">Xem chi tiet</a>
                               </div>

                            </div>
                            <div class="col-md-3 product-detail">
                               <div class="hinhanh">
                                 <img src="images/suaphap_4.jpg" class="img-responsive" alt="Responsive image">
                               </div>
                               <div class="ten">
                                 Sữa Celia Expert Số 3 - 900g (1-3 tuổi)
                               </div>
                               <div class="gia">
                                 378.000 VND
                               </div>
                               <div class="chitiet">
                                <a href="">Xem chi tiet</a>
                               </div>

                            </div>
                            <div class="col-md-3 product-detail">
                               <div class="hinhanh">
                                 <img src="images/suaphap_2.jpg" class="img-responsive" alt="Responsive image">
                               </div>
                               <div class="ten">
                                 Sữa Celia Expert Số 3 - 900g (1-3 tuổi)
                               </div>
                               <div class="gia">
                                 378.000 VND
                               </div>
                               <div class="chitiet">
                                <a href="">Xem chi tiet</a>
                               </div>

                            </div>
                            <div class="col-md-3 product-detail">
                               <div class="hinhanh">
                                 <img src="images/abbott_1.jpg" class="img-responsive" alt="Responsive image">
                               </div>
                               <div class="ten">
                                 Sữa Celia Expert Số 3 - 900g (1-3 tuổi)
                               </div>
                               <div class="gia">
                                 378.000 VND
                               </div>
                               <div class="chitiet">
                                <a href="">Xem chi tiet</a>
                               </div>

                            </div>
                            
                         <div class="clearfix"></div>
                        </div>
							<div class="phantrang">
								<nav aria-label="Page navigation">
								  <ul class="pagination">
								    <li>
								      <a href="#" aria-label="Previous">
								        <span aria-hidden="true">&laquo;</span>
								      </a>
								    </li>
								    <li><a href="#">1</a></li>
								    <li><a href="#">2</a></li>
								    <li><a href="#">3</a></li>
								    <li><a href="#">4</a></li>
								    <li><a href="#">5</a></li>
								    <li>
								      <a href="#" aria-label="Next">
								        <span aria-hidden="true">&raquo;</span>
								      </a>
								    </li>
								  </ul>
								</nav>              	
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
    <footer class="bg-footer">
        <img src="images/footter-1.jpg" class="img-responsive" >
        <div class="container ">

            <div class="col-md-3">

                <p class="phone">0977387228</p>
            </div>
            <div class="col-md-5">
              <p class="address"><strong>180-182, đường Ngô Gia Tự</strong><br/>
              Phường 9, Quận 10, Thành phố Hồ Chí Minh, Việt Nam </p>
            </div>
            <div class="col-md-4">
              <ul class="list-unstyled pull-right">
                <li class="pull-left">
                  <img src="images/fb.png" alt="faceboook" class="img-responsive lh">
                </li>
                <li class="pull-left">
                  <img src="images/tw.png" alt="faceboook" class="img-responsive lh">
                </li>
                <li class="pull-left">
                  <img src="images/gg.png" alt="faceboook" class="img-responsive lh">
                </li>
                <li class="pull-left">
                  <img src="images/email.png" alt="faceboook" class="img-responsive lh">
                </li>
              </ul>
            </div>
        </div>
        </div>
    </footer>
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>