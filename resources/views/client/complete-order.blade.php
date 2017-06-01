@extends('layouts.home')
@section('css')
  <link href="{{ asset('web-bansua/style.css') }}" rel="stylesheet">
@endsection

@section('body')
   <br><br>
    <div class="container" style="font-size: 200%">
      <div class="main-content">
         <div class="panel-heading"><center><b>Xin chân thành cảm ơn quý khách đã đặt hàng. </b></center></div>
         <div class=""><center><b>Đơn hàng đã đặt thành công, đang được chúng tôi kiểm tra thông tin và xác nhận. </b></center></div>
         <div><center><b>Đơn đặt hàng của bạn: <a href="#">#{{$id}}</a> </b></center></div>
      </div>
    </div>
@endsection