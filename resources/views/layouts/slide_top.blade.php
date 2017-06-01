@foreach($slide as $key=>$e)
@if($key==0)
	<a class="mySlides" style="display: block;"  href="{{$e->link}}"><img src="{{ asset('upload/logo/'.$e->anh) }}" style="height:100%;width: 100%"></a>
@else
<a class="mySlides" href="{{$e->link}}"><img src="{{ asset('upload/logo/'.$e->anh) }}" style="height:100%;width: 100%"></a>
@endif
@endforeach<div id="listIconSlide">@foreach($slide as $key=> $e)
@if($key==0)<img id="iconSlide1" onclick="nextSlideTop({{$key}},true)" style="border-color: red" class="" src="{{ asset('upload/logo/'.$e->anh) }}" alt="">
@else
<img id="iconSlide1" onclick="nextSlideTop({{$key}},true)" class="" src="{{ asset('upload/logo/'.$e->anh) }}" alt="">
@endif
@endforeach($slide->$e)</div>