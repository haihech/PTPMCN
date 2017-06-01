<!DOCTYPE html5>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sữa VN</title>

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('js/jquery.number.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('css/header.css') }}">

	<link rel="stylesheet" href="{{ asset('css/default.css') }}">
	<link href="{{ asset('products/css/style.css') }}" rel="stylesheet">
	<link href="{{asset('css/style.css')}}" rel="stylesheet">
  
	<link href="{{asset('font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('js/btn_top.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/btn_top.css')}}" >
</head>
<body>
	<header>	
		<div class="top-header">
				<div id="logo"><a href="{{ url('web-bansua/home') }}"><img alt="" class="logo"></a></div>
				<div id="menu">
					<ul>
						<li class="kkk"><a>Thương Hiệu</a><div class="submenu">
								@foreach ($thuonghieu as $e)
									<a href="{{ url('web-bansua/thuonghieu',[$e->id]) }}">{{$e->ten}}</a>
								@endforeach
							</div>
						</li>
						<li><a>Nhóm Tuổi</a><div class="submenu">
								@foreach ($tuoi as $e)
									<a href="{{ url('web-bansua/nhomtuoi',[$e->id]) }}">Tuổi {{$e->tuoi}}</a>
								@endforeach
							</div>
						</li>
						<li><a href="{{ url('web-bansua/khuyenmai') }}">Khuyến Mãi</a></li>
						<li><a href="{{ url('web-bansua/giamgia') }}">Giảm Giá</a></li>
					{{-- 	<li><a href="">Tin Tức</a></li> --}}
					</ul>
				</div>
				<script>
				</script>
				<div id="iconMenu" ><img onclick="openMenu()" src="{{ asset('upload/logo/menu.png') }}" alt=""></div>
					
				<div class="account info">
					<div id="iconAccount"  style="cursor: pointer;" onclick="openAccount()"></div>
					<div id="block_screen_account" style="position: fixed;width: 100%;height: 100%;top:0;left: 0;z-index: 1000; display: none" onclick="hiddenAccount()"></div>
					<div id="infoAccount">
						@if(Auth::guest())
							<style>
								#formLogin{
									background: #fff;
									padding: 20px 20px 10px 20px;
									border-top: 5px solid #FF0000;
									z-index: 1500
								}
								#formLogin input{
									padding:5px;
									border: 1px solid #898989;
									border-radius: 4px;
									margin-bottom: 5px;
								}
								#formLogin button{
									border: none;
									background: transparent;
									color:#3A3A3A;
									font-size: 90%;
									display: inline-block;
								}
								#formLogin span{
									text-decoration: underline;
									margin-left: 20px;
									color:#616161;
									font-size: 80%;
								}
							</style>
							<form action="{{ url('/web-bansua/signin') }}" id="formLogin" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<table>
									<tr><td><input type="text" name="username" id="" placeholder="Tên đăng nhập" required=""></td></tr>
									<tr><td><input type="password" name="password" placeholder="Mật khẩu" required=""></td></tr>
									<tr style="margin-top: 10px">
										<td><button type="submit">Đăng nhập</button>
										<span onclick="showFormRegister()">Đăng ký<span></td>
									</tr>
								</table>
							</form>
						@else
						<style>
							#menuAccount{
								background: #fff;
								border-top: 5px solid #FF0000;
								padding:10px;
								border-bottom: 1px solid #797979;
							}
							#menuAccount a{
								display: inline-block;
								width: 170px;
								padding: 5px 10px;
								color:#636363;
							}
							#menuAccount a:hover{
								color:#FF0909;
							}
						</style>
						<ul id="menuAccount">
							<li><a href="">Trang cá nhân</a></li>
							<li><a href="">Lịch sử mua hàng</a></li>
							<li><a href="{{ url('/web-bansua/logout') }}">Đăng xuất</a></li>
						</ul>
						@endif
					</div>
				</div>
				@if(Auth::guest())
				<div id="lock-screen-register""><div id="formregister">@include('layouts.formRegister')</div></div>
				@endif
				<div class="cart info"><a href="{{ url('/web-bansua/shopping-cart') }}">
				@if(session()->has('cart'))
					@if(count(session()->get('cart')->listSp)>0)
					<img src="{{ asset('upload/logo/cart_active.png') }}" id="icon_cart_hh"alt="">
					@else <img id="icon_cart_hh" src="{{ asset('upload/logo/cart.png') }}" alt="">
					@endif
				@else <img id="icon_cart_hh" src="{{ asset('upload/logo/cart.png') }}" alt="">
				@endif
				</a></div>
				<form action="{{ url('web-bansua/home/search') }}" method="get" id="search"><input type="text" name="tensp" placeholder="" id="inputSearch" onfocus="openSearch()" onfocusout="hiddenSearch()"></form>
				<script>
					function ss(){
						url="{{URL::to('web-bansua/home/support/search')}}";
					    $.ajax({
					      url:url,
					      method: "GET",
					      success:function(data){
					        $('#kienthuc').append(data);
					      }
					    });
					}
				</script>
		</div>
	</header>
	<div style="width: 100%;position: relative;display:inline-block;height: 450px;background: #222;">
		<div id="slideTop"></div>
		{{-- <div id="tintuc">
			<div id="tabtintuc">
				<p for="">Kiến Thức</p>
				<label for=""></label>
				<label for=""></label>
			</div>
			<div id="kienthuc"></div>
		</div> --}}
	</div>
	@yield('body')
	<footer>
		@include('layouts.footer')
	</footer>
	<script>
		function dathang2 (id) {
		var val = 1;
          var url="{{URL::to('web-bansua/addtocart')}}"+"/"+id+"/"+val;
          $.ajax({
            url:url,
            method: "GET",
            success:function(data){
              if(data=='Đặt hàng thành công!')
                document.getElementById("icon_cart_hh").src='{{ asset('upload/logo/cart_active.png') }}';
                alert(data);

	            }
	          });
	      }
		function showFormRegister(){
			document.getElementById("infoAccount").style.display="none";
			var x=document.getElementById('lock-screen-register');
			var y=document.getElementById('formregister');
			y.style.top=0;
			y.style.display="inline-block";
			x.style.display="block";
			y.style.right=(window.innerWidth-y.getBoundingClientRect().width)/2+"px";
			action=setInterval(dropdown,5);
		}
		var action=null;
		var action2=null;
		function dropdown(){
			var y=document.getElementById('formregister');
			y.style.top=parseInt(y.style.top) + 2 + 'px';
			if(y.style.top=='160px'){
				clearInterval(action);
				action2=setInterval(skewY,5);
			}
		}
		var skew=0;
		var xxx="up";
		var up=10;
		var down=-10;
		function skewY(){
			var y=document.getElementById('formregister');
			y.style.transform="skewY("+skew+"deg)";
			if(xxx=="up"){
				skew++;
			}else if(xxx="down"){
				skew--;
			}
			if(skew==up){
				xxx="down";
				down+=2;

			}
			if(skew==down){
				xxx="up";
				up-=2;
			}
			if(skew==down&&skew==0) {
				clearInterval(action2);
				y.style.transform="skewY(0deg)";
				skew=0;
				xxx="up";
				up=10;
				down=-10;
			}
		}
		function hiddenFormRegister(){
			document.getElementById('lock-screen-register').style.display="";
			document.getElementById('formregister').style.display="";
		}
	</script>
	<script>
		function openMenu () {
			document.getElementById("menu").style.display='block';
			var x=document.getElementById("menu");
		}
		function hiddenAccount()  {
			document.getElementById("block_screen_account").style.display='none';
			document.getElementById("infoAccount").style.display='none';
		}
		function openAccount (event) {
			x=document.getElementById("infoAccount");
			var header=document.getElementsByTagName('header')[0];
			if(x.style.display!='block'){
				x.style.display='block';
				document.getElementById("block_screen_account").style.display='block';
				x.style.top=header.clientHeight-document.getElementById("iconAccount").parentElement.offsetTop;
				document.getElementById("iconAccount").setAttribute('src','{{ asset('upload/logo/accountActive.png')}}');
			}else{
				x.style.display='none';
				document.getElementById("iconAccount").src='{{ asset('upload/logo/account.png') }}';
			}
		}
		function openSearch () {
			var s=document.getElementById("search");
			var menu=document.getElementById("menu");
			var size=window.innerWidth;
			if(size<=1024){

			}else{
				s.style.width="50%";
				menu.style.display="none";
			}
		}
		function hiddenSearch (){
			var s=document.getElementById("search");
			var menu=document.getElementById("menu");
			var size=window.innerWidth;
			if(size<=1024){

			}else{
				s.style.width="35px";
				menu.style.display="block";
			}
		}
	</script>
	{{-- script slide --}}
	<script>
		var actionSlideTop;
		jQuery(document).ready(function($) {
			var url="{{URL::to('web-bansua/loadSlide')}}";
		    $.ajax({
		      url:url,
		      method: "GET",
		      success:function(data){
		        $('#slideTop').append(data);
		        resetSlideTop();
		      }
		    });
		    url="{{URL::to('web-bansua/loadNews')}}";
		    $.ajax({
		      url:url,
		      method: "GET",
		      success:function(data){
		        $('#kienthuc').append(data);
		      }
		    });
		});

		function carousel() {
			var i;
			var x = document.getElementById("listIconSlide").getElementsByTagName("img");
			var currentIndex=0;
			for (i = 0; i < x.length; i++) {
		       if(x[i].style.borderColor == "red"){
			       	currentIndex=i;
			       	break;
		       }
		    }
		    currentIndex++;
		    if(currentIndex>=x.length) currentIndex=0;
		    nextSlideTop(currentIndex,false);
		    actionSlideTop=setTimeout(carousel,2500);
		}
		function resetSlideTop () {
			 setTimeout(carousel,2500);
		}
		function nextSlideTop(index,resetSlide){
			if(resetSlide){
				clearTimeout(actionSlideTop);
				actionSlideTop=setTimeout(resetSlideTop,3000);
			}
			var x = document.getElementById("listIconSlide").getElementsByTagName("img");
		    for (i = 0; i < x.length; i++) {
		       x[i].style.borderColor = "#FFF";
		    }
		    var itemClicked=x[index];
		    itemClicked.style.borderColor="red";

		     x = document.getElementsByClassName("mySlides");
		    for (i = 0; i < x.length; i++) {
		    	if(x[i].style.display == "block"){
		    		 x[i].className="mySlides slidetop_hidden";
		    	}
		    }
		    x[index].style.display="block";
		    x[index].className="mySlides slidetop_show";
		}
	</script>
	@if(session()->has('showFormRegister'))
		<script> showFormRegister()</script>
	@endif
	@if(session()->has('showFormLogin'))
		<script> openAccount()</script>
	@endif
</body>
</html>