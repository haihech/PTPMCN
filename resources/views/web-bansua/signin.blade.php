@extends('web-bansua.index')
@section('css')
  <link href="{{ asset('web-bansua/style.css') }}" rel="stylesheet">
@endsection
@section('content')
     
    <div class="container">
      <div class="main">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <h1>Đăng nhập</h1>
            @if(count($errors) > 0)
               <div class="alert alert-danger">
                 @foreach($errors->all() as $error)
                     <p>{{ $error }}</p>
                 @endforeach
               </div>
            @endif
            <form action="{{ url('signin')}}" method="post">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              
              <button type="submit" class="btn btn-success pull-right">Đăng nhập</button>
              {{ csrf_field() }}
            </form>
          </div>
        </div>
      </div>
      
    </div>

@endsection
