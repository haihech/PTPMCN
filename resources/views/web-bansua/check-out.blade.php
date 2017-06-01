@extends('web-bansua.index')
@section('css')
  <link href="{{ asset('web-bansua/style.css') }}" rel="stylesheet">
@endsection
@section('content')
  
  <div class="container clearfix"> 
    
    <form  action="{{ url('order-bill') }}" method="post">
    <div class="col-4 step1">
      <h2>Thông tin giao hàng</h2>
            
      @if(!Session::has('account'))
      <div class="user-login"><a href="{{ url('signup') }}">Đăng ký tài khoản mua hàng</a> | <a href="{{ url('signup') }}">Đăng nhập</a></div>
      <div class="line"></div>
      
      <div class="form-info">
        <div><br/></div>
        <label class="color-blue">Mua không cần tài khoản</label>
      @else
      <div class="form-info">
        <label class="color-blue">Mua hàng có tài khoản</label>
      @endif

        <div class="new_order">
                
          @if(!Session::has('account'))
          <div class="form-group">
            <input placeholder="Họ và tên" class="form-control" id="billing_address_full_name" name="billing_address_full_name" size="30" type="text" required="" aria-required="true">
          </div>
          
          

          <div class="form-group">
            <input placeholder="Số điện thoại" maxlength="11" id="billing_address_phone" class="form-control" name="billing_address_phone" size="30" title="Nhập số điện thoại" pattern="^\d{8,11}" type="tel" value="" required="" aria-required="true">
            
          </div>
          
          <div class="form-group">
            <input placeholder="Email" id="order_email" name="order_email" class="form-control" size="30" type="email" value="" required="" aria-required="true">
            
          </div>

          @else

          <div class="form-group">
            <input class="form-control" id="billing_address_full_name" name="billing_address_full_name" size="30" type="text" required="" aria-required="true" value="{{Session::get('account')->ten}}">
          </div>
          
          

          <div class="form-group">
            <input maxlength="11" id="billing_address_phone" class="form-control" name="billing_address_phone" size="30" title="Nhập số điện thoại" pattern="^\d{8,11}" type="tel" value="{{Session::get('account')->sdt}}" required="" aria-required="true">
            
          </div>
          
          
          <div class="form-group">
            <input placeholder="Email" id="order_email" name="order_email" class="form-control" size="30" type="email" value="{{Session::get('account')->email}}" required="" aria-required="true">
            
          </div>

          @endif
          
          
          <p><b>Địa chỉ giao hàng</b></p>
          
          <div class="form-group">                   
            <textarea id="billing_address_note" placeholder="Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường' để tránh trường hợp đơn hàng bị hủy ngoài ý muốn" name="billing_address_note" rows="3" class="form-control ordernote" required="" aria-required="true"></textarea>
          </div>
          
          <div class="form-group">
              <div class="dropdown">
               <div class="dropdown-toggle">
                   <select id="billing_address_province" name="billing_address_province" class="form-control" required="" aria-required="true">
                  <option value="null" selected="">Vui lòng chọn tỉnh/thành phố.</option>
                        <option value="Hà Nội">Hà Nội</option>
                   </select>
               </div>
              
            </div>
          </div>
          <div class="form-group">
              <div class="dropdown">
               <div class="dropdown-toggle">
                   <select id="billing_address_district" name="billing_address_district" class="form-control" required="" aria-required="true">
                  <option value="null" selected="">Vui lòng chọn quận/huyện.</option>
                        <option value="Hai Bà Trưng">Hai Bà Trưng</option>
                        <option value="Ba Đình">Ba Đình</option>
                        <option value="Hoàng Mai">Hoàng Mai</option>
                   </select>
               </div>
              
            </div>
          </div>
          <div class="form-group">
              <div class="dropdown">
               <div class="dropdown-toggle">
                   <select id="billing_address_ward" name="billing_address_ward" class="form-control" required="" aria-required="true">
                  <option value="null" selected="">Vui lòng chọn phường/xã.</option>
                        <option value="Phường Bách Khoa">Phường Bách Khoa</option>
                        <option value="Phường Trương Định">Phường Trương Định</option>
                        
                   </select>
               </div>
              
            </div>
          </div>
          
          </div>
          <div class="form-group">                   
            <textarea id="billing_note" placeholder="Ghi chú đơn hàng" name="billing_note" rows="3" class="form-control ordernote"></textarea>
          </div>
          <div class="error summary">
            (<span class="color-red ">*</span>)Vui lòng nhập đủ thông tin</div> 
        </div>
        </div>
          <div class="col-4 step1">
            <h2>Hình thức thanh toán</h2>
            <div class="shiping-ajax">

              <label class="lb-method">
                <input class="input-method" type="radio" checked="checked" name="gateway" value="">
                <span class="label-radio"> Thanh toán khi giao hàng (COD)</span>
              </label>
              <span class="desc" style="display: block;">Quý khách sẽ thanh toán bằng tiền mặt khi nhận hàng tại nhà.
              </span>
              <span class="desc"></span>
            </div>
            
            
          </div>
            <div class="col-4 step1">
                <h2>Đơn hàng</h2>
                (<span>{{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }}</span> sản phẩm)
                <div class="cart-items">
                  
                  @foreach(Session::get('cart')->items as $p)     
                  <div class="list_item cart-item">
                    <span>{{$p['qty']}} x</span>                        
                    <span> {{$p['item']['ten']}}</span>
                    <span class="price">{{$p['price']}}<u>đ</u></span>
                    <p class="variant-title"></p>
                  </div> 
                  @endforeach 
                  
                  
                </div>                
                <div class="total-price">
                  Tổng tiền   <label> {{ Session::has('cart') ? Session::get('cart')->totalPrice : '0' }}<u>đ</u></label>
                </div>
                <div class="shiping-price">
                  Phí vận chuyển   <label>0<u>đ</u></label>
                </div>          
                <div class="total-checkout">
                  Số tiền cần thanh toán <label><span> {{ Session::has('cart') ? Session::get('cart')->totalPrice : '0' }}<u>đ</u></span></label>
                </div>
              
              <button type="submit" class="btn-checkout">Đặt hàng</button>
              {{ csrf_field() }}
              
            <p id="dieukhoan">Bằng cách đặt hàng, bạn đồng ý với <a href="#">điều khoản sử dụng</a> của SuaNhapNgoai</p></div>
        
        
      </form>
          
  </div>
@endsection