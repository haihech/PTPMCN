<style>

.formRegister{
	text-align: center;
	display: inline-block;
	position: relative;
	padding:10px 20px;
}
.formRegister img{
	position: absolute;
	width: 30px;
	height: 30px;
	opacity: 0.5;
	top:0px;
	right:0px;
}
.formRegister img:hover{
	opacity: 1;
}
.formRegister h3{
	font-size: 28px;
}
.formRegister form{
	margin-top: 20px;
	display: inline-block;
}
.formRegister input{
	padding:10px 20px;
	font-size: 16px;
	display:block;
	margin-top: 15px;
	border:1px solid #A5A2A2;
	border-radius:4px;
}
.submitFormRegister{
	background: #0095FD;
	border-radius: 8px;
	color:#fff;
}
</style>
<div class="formRegister">
<img onclick="hiddenFormRegister()" src="{{ asset('upload/logo/exit.png') }}" alt="exit">
<h3>Đăng Ký</h3>
<form action="{{URL('register')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="text" name="username" id="Register-name" placeholder="Tên đăng nhập" value="{{ old('username') }}">
	@if($errors->has('username'))
					<script>
						var x=document.getElementById('Register-name');
						x.style.border="1px solid #FB5E5E";
						x.setAttribute("title","{{$errors->first('name')}}");
					</script>
					@endif
	<input type="text" name="email" id="Register-email'" placeholder="Địa chỉ email" value="{{ old('email') }}">
	@if($errors->has('email'))
	<script>
		var x=document.getElementById('Register-email');
		x.style.border="1px solid #FB5E5E";
		x.setAttribute("title","{{$errors->first('email')}}");
	</script>
	@endif
	<input type="password" name="password" id="Register-password" placeholder="Mật khẩu" value="{{ old('password') }}">
	@if($errors->has('password'))
	<script>
		var x=document.getElementById('Register-password');
		x.style.border="1px solid #FB5E5E";
		x.setAttribute("title","{{$errors->first('password')}}");
	</script>
	@endif
	<input type="password" name="password_confirmation" id="Register-passwordconfirm" placeholder="Nhập lại mật khẩu">
	@if($errors->has('password_confirmation'))
	<script>
		var x=document.getElementById('Register-passwordconfirm');
		x.style.border="1px solid #FB5E5E";
		x.setAttribute("title","{{$errors->first('password_confirmation')}}");
	</script>
	@endif
	<input type="submit" value="Tạo ngay" class="submitFormRegister">
</form>
</div>