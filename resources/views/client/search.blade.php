<link rel="stylesheet" href="{{ asset('css/menu_left.css') }}">
<link rel="stylesheet" href="{{ asset('css/content_home.css') }}">
@extends('layouts.home')
@section('body')
<div style="width: 90%;margin:auto;padding: 20px 0;">
	<div style="text-align: left;background: #D1D1D1;padding: 10px 20px;border-radius: 4px;"><h3>Tìm thấy {{$nums}} sản phẩm!</h3></div>
	{!!$view!!}
</div>
	
@endsection