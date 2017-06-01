<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Sua</title>
		<!-- Bootstrap -->
		<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
		<link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet">
		<link href="{{asset('font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/btn_top.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/btn_top.css')}}" >
    @yield('css')
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
              <a class="navbar-brand" href="#"><img alt="Brand" src="{{asset('images/brand.png')}}"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav menu">
                  <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home"></span> Trang chủ</a></li>
                  <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Đơn hàng</a></li>
                  <li><a href="#"><i class="fa fa-cube" aria-hidden="true"></i> Giới thiệu</a></li>
              </ul>

              <form action="{{ url('search') }}" method="get" class="navbar-form navbar-left" >
                  <div class="input-group">
                      <div class="ui-widget">
                        <input type="text" id="search" name="search" class="form-control" placeholder="Nhập tên sữa...">
                        <div class="dropdown-menu" id="productList" role="menu"></div>
                      </div>
                            
                  </div>
                  <div class="input-group">
                    <input type="submit" name="search-product" value="Tìm kiếm" class="btn btn-primary">
                  </div>
              </form>
              <ul class="nav navbar-nav navbar-right menu">
                  
                  
                  <li><a href="{{ route('shoppingCart') }}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Giỏ hàng (<span id="count_item">{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span>)<br /> <span class="cart-price">{{ Session::has('cart') ? Session::get('cart')->totalPrice.'đ' : '0đ' }}</span></a></li>
                  @if(!Session::has('account'))
                  
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tài khoản<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('signin')}}" class="btn" role="button">Đăng nhập</a></li>
                        <li><a href="{{ url('signup') }}" class="btn" role="button">Đăng ký</a></li>
                           
                    </ul>
                  </li>
                  @else
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Session::get('account')->ten}}<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <li><a href="#" class="btn" role="button">Thông tin tài khoản</a></li>
                          <li><a href="#" class="btn" role="button">Kiểm tra đơn hàng</a></li>
                          <li class="divider" role="separator"></li>
                          <li><a href="{{ url('logout') }}" class="btn" role="button">Đăng xuất</a></li>
                             
                      </ul>
                    </li>
                  @endif
                
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </header>
     
    @yield('content')         
    
    <footer class="bg-footer">
        <img src="{{asset('images/footter-1.jpg')}}" class="img-responsive" >
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
                  <img src="{{asset('images/fb.png')}}" alt="faceboook" class="img-responsive lh">
                </li>
                <li class="pull-left">
                  <img src="{{asset('images/tw.png')}}" alt="faceboook" class="img-responsive lh">
                </li>
                <li class="pull-left">
                  <img src="{{asset('images/gg.png')}}" alt="faceboook" class="img-responsive lh">
                </li>
                <li class="pull-left">
                  <img src="{{asset('images/email.png')}}" alt="faceboook" class="img-responsive lh">
                </li>
              </ul>
            </div>
        </div>
        </div>

        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script type="text/javascript">
          $('#search').on('keyup',function(){
            $value = $(this).val();
            $.ajax({
                url:'{{URL::to('home/search')}}',
                method: "GET",
                data:{'search':$value},
                success:function(data){
                  $('#productList').fadeIn();
                  $('#productList').html(data);
                }
              });
          });
          $(document).on('click','li', function(){
            $datas = $('#productList').html();
            if($datas.includes($(this).text())){
              $('#search').val($(this).text());
              $('#productList').fadeOut();
            }
          });
          
        </script>

        @yield('javascript')

    </footer>

	</body>
  <script>
    
  </script>

</html>
