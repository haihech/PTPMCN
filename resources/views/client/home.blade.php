<link rel="stylesheet" href="{{ asset('css/menu_left.css') }}">
<link rel="stylesheet" href="{{ asset('css/content_home.css') }}">
@extends('layouts.home')
@section('body')

	{{-- @include('layouts.menu_left') --}}
	<div class="content">
		<div class="link_content"></div>
		<style>
			.nextSlideKM{
				font-size: 250%;z-index: 1000;position: absolute;
				font-weight: bold;
				padding:20px 5px;
				top:35%;
				cursor: pointer;
				vertical-align: middle;
				line-height: 100%;
				border-radius: 4px;
			}
			.nextSlideKM:hover{
				background: rgba(0,0,0,0.3);
				color:#fff;
			}
		</style>
		@if($sql->nhomtuoi==-1&&$sql->thuonghieu==-1&&$sql->giamgia==-1&&$sql->khuyenmai==-1&&$sql->hot==-1)

		<div class="components" >
			<div class="titleComponents"><a href="{{ url('web-bansua/hot') }}">Hot<span> &#10095 </span></a></div>
			<div style="position: relative;display: inline-block;overflow:hidden;height: 290px;width: 100%;">
			<div id="slideListHot" >
			</div>
			<span style="left: 0;" class="nextSlideKM" onclick="nextSlideHot(false)"> &#10092 </span>
			<span style="right:0;" class="nextSlideKM" onclick="nextSlideHot(true)"> &#10093 </span>
			</div>
		</div>
		<div class="components" id="test">
			<div class="titleComponents"><a href="{{ url('web-bansua/khuyenmai') }}">Khuyến Mãi <span> &#10095 </span></a></div>
			<div style="position: relative;display: inline-block;overflow:hidden;height: 300px;width: 100%;">
			<div id="slideListKm" >
			</div>
			
			<span style="left: 0;" class="nextSlideKM" onclick="nextSlideKm(false)"> &#10092 </span>
			<span style="right:0;" class="nextSlideKM" onclick="nextSlideKm(true)"> &#10093 </span>
			</div>
		</div>
		<script>
			window.onload=function function_name (argument) {
			var url="{{URL::to('web-bansua/loadKhuyenMai/0/0')}}";
		    $.ajax({
		      url:url,
		      method: "GET",
		      success:function(data){
		        $('#slideListKm').append(data);
		        setTimeout(function () {
				        	var div=document.getElementById("slideListKm");
							var list=div.children;
							div.style.width=list[0].clientWidth*(list.length);
							//slideKM(0);
		       		 	}, 1000);
		    	}
		    });
		   loadHot();
	}	       
		</script>
		@endif
		<div class="components" >
			<div class="titleComponents"><a>
			@if($sql->nhomtuoi==-1&&$sql->thuonghieu==-1&&$sql->giamgia==-1&&$sql->khuyenmai==-1&&$sql->hot==-1)Tất Cả
			@else
				@if($sql->thuonghieu!=-1) Thương Hiệu: {{$sql->th}} @endif
				@if($sql->nhomtuoi!=-1) <span style="margin-left: 10px"></span>Nhóm tuổi: {{$sql->t}} @endif
				@if($sql->giamgia!=-1) <span style="margin-left: 10px"></span>Giảm Giá  @endif
				@if($sql->khuyenmai!=-1) <span style="margin-left: 10px"></span>Khuyến Mãi  @endif
				@if($sql->hot!=-1) <span style="margin-left: 10px"></span>Hot @endif
			@endif
			<span> &#10095 </span></a></div>
			<div id="containerProduct"></div>
			{{-- @include('layouts.product', ['list' =>$data,'classN'=>'eProduct']) --}}
		</div>
		<div id="loadProduct"><img src="{{ asset('upload/logo/loading2.gif') }}" alt=""></div>
	</div>

<script>
	var readyLoadProduct=true;
	function loadProduct(){

		k=document.body.clientWidth;
		var n;
		var Url;
		var index=$('#containerProduct').children('div').length;
		if(k<480) n=6;
		else if(k<800) n=9;
		else n=5;

		@if($sql->khuyenmai==-1 && $sql->hot==-1)
		    Url="{{URL::to('web-bansua/loadProduct')}}"+"/"+index+"/"+n+"/"+{{$sql->thuonghieu}}+"/"+{{$sql->nhomtuoi}}+"/"+{{$sql->giamgia}};
		
		@elseif($sql->khuyenmai!=-1)
			Url="{{URL::to('web-bansua/loadKhuyenMai/1')}}"+"/"+index;
			
		@elseif($sql->hot!=-1)
			Url="{{URL::to('web-bansua/loadHot/t/1')}}"+"/"+index;
			
		@endif

	    $.ajax({
	      url:Url,
	      method: "GET",
	      success:function(data){
	        $('#containerProduct').append(data);
	        readyLoadProduct=true;
	      }
	    });
	  };
	var actionSlideKM=null;
	function slideKM (n=0,left=true) {
		n=Number((n).toFixed(0));
		div=$('#slideListKm').first();
		if(n==0&&!left) return;
		if(n<div.parent().width()-div.innerWidth()&&left)return;

		if(n>0) left=true;
		else if(n<div.parent().width()-div.innerWidth()){
			left=false;
		}
		if(left)n--;
		else n++;
		div.css({
			left: ''+n+'px'
		});
		w=$('#slideListKm').first().children().get(0).clientWidth;
		if(Math.abs(n)%w==0||n==document.body.clientWidth-div.width()) {
			return;
		}
		else{
			actionSlideKM=setTimeout(slideKM,1,n,left);
		}
		
		
		
		//actionSlideKM=setTimeout(slideKM,20,n,left);
	}
	function nextSlideKm (left) {
		if(actionSlideKM!=null){
			clearTimeout(actionSlideKM);
		}
		slideKM($('#slideListKm').first().position().left,left);
	}
	var actionSlideHot;
	function slideHot (n=-1,left=true,w) {
		n=Number((n).toFixed(0));
		div=$('#slideListHot').first();
		if(n>=0) left=true;
		else if(n<div.parent().width()-div.outerWidth()){
			left=false;
		}
		div.css({
			left: ''+n+'px'
		});
		if(left)n--;
		else n++;
		if(Math.abs(n)%w==0||n==document.body.clientWidth-div.width()) {
			actionSlideHot=setTimeout(slideHot,2000,n,left,w);
		}
		else{
			actionSlideHot=setTimeout(slideHot,5,n,left,w);
		}
	}
	function nextSlideHot (left) {
		clearTimeout(actionSlideHot);
		var div=$('#slideListHot').first();
		var w=div.children().get(0).clientWidth;
		actionSlideHot=setTimeout(slideHot,2000,div.position().left,left,w);
	}

	function loadHot(time='t'){
		 url="{{URL::to('web-bansua/loadHot/')}}"+"/"+time+"/0";
		    $.ajax({
		      url:url,
		      method: "GET",
		      success:function(data){
		        $('#slideListHot').append(data);
		        setTimeout(function () {
				        	var div=document.getElementById("slideListHot");
							var list=div.children;
							div.style.width=list[0].clientWidth*(list.length);
							slideHot(-1,true,list[0].clientWidth);
		       		 	}, 1000);
		    	}
		    });
	}
	window.onscroll=function loadMoreProduct(){
		var x=document.getElementById("loadProduct");
		var k=document.getElementById("containerProduct");
		if ((document.body.scrollTop+document.body.clientHeight)>=(x.offsetTop+x.clientHeight)&&readyLoadProduct){
		 	readyLoadProduct=false;
		 	loadProduct();
		 }
	}
	
</script>
@endsection