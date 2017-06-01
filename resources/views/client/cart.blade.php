@extends('layouts.home')
  <link href="{{ asset('web-bansua/style.css') }}" rel="stylesheet">
@section('body')
    <br><br>
    <div class="main-wrap ">
      <div class="cart-wrapper">
      <div class="container">
       <div class="cart-wrap vnm-wrap-bg">
      <!-- row -->
      
       <div class="row row_fix">

        @if( count($products)!=0)
        <div class="col-md-9">
          <div class="cart__wrap-item">

              <div class="col-md-6">
                <h4 class="cart-title">
                  Giỏ hàng của bạn <span>(<span id="count_cart">{{ count($products) }}</span> sản phẩm)</span>
                </h4>
              </div>
            
             {{--  <div class="wrap_note clearfix col-md-6 hidden-xs hidden-sm">
                <div class="vnm-alert col-md-5 col-md-push-2" style="padding-left: 0">
                  <div class="icon"><img src="{{ asset('images/icon_location.png') }}"></div>
                  <div class="text">
                    <div class="text">Giao hàng toàn quốc</div>
                  </div>
                </div>
              
              </div> --}}
            <script>
                      function a(){
                         var tong=0;
                        for(var i=0;i<{{count($products)}};i++){
                          tong+=parseInt($('#price-'+i).text().replace(',',''))*
                           parseFloat($('#number-'+i).val());
                        }
                        $('#thanhtien').number(tong);
                      }
                      function xoa(row){
                        document.getElementById("table-giohang").deleteRow(row+1);
                      }
                    </script>
            <div class="cart__items">
              <form action="{{ url('web-bansua/update-cart') }}" method="post">
                <table class="cart__table table table-condensed table-hover rwd-table" id="table-giohang">
                  <thead>
                    <tr>
                      <th class="title_cart_name">Sản phẩm</th>
                      <th>Đơn giá</th>
                      <th>Số lượng</th>
                      <th>Thành tiền</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $key=>$product)
                    <tr class="line-item-container" id="row-{{$key}}">
                      <td class="image">
                        
                        <div class="product_image">                         
                          <a href="{{ url('web-bansua/products', [$product->id]) }}">
                            <img style="max-height: 100px;width: auto" src="{{ asset('images/'.$product->anh) }}">
                          </a>                          
                        </div>
                        <div class="product_text">
                          <a href="{{ url('web-bansua/products', [$product->id]) }}">
                            <strong>{{$product->ten}}</strong>
                          </a>
                          <a class="cart cart_remove" onclick="xoa({{$key}})">
                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-times-circle" aria-hidden="true" data-original-title="Xóa"></i> 
                            Xóa sản phẩm
                          </a>

                        </div>
                        
                      </td>
                     
                      <td class="price" >        
                        <span id="price-{{$key}}"><?php echo number_format($listPrice[$key]).' '; ?></span><u>đ</u>     
                      </td>
                     
                      
                      <td class="qty">
                        <div class="incrementer vnm-incrementer detail dropdown-toggle" >
                          <button type="button" class="qtyplus-{{$product->id}}" style="top: 0; right: 0;"><i class="fa fa-caret-up"></i></button>
                          <input  id="number-{{$key}}" name="number-{{$product->id}}" type="number" min="1" max="9999" onkeyup="if(this.value>9999){this.value='9999';}else if(this.value<1){this.value='1';}" class="form-control" value="{{$listNum[$key]}}">
                          <button type="button" class="qtyminus-{{$product->id}}" style="right: 0; bottom: 0;"><i class="fa fa-caret-down"></i></button>
                         </div> 
                      </td>
                      <td style="color:red" data-th="Thành tiền">
                         <span class="price price_line" style="margin-right: 10px" id="total-{{$key}}"> <?php echo number_format($listNum[$key] * $listPrice[$key]).' ' ?></span><u>đ</u>
                      </td>
                      
                    </tr>
                    <script>
                      $(document).on('click', '.qtyplus-{{$product->id}}', function() {
                        $('#number-{{$key}}').val(parseInt($('#number-{{$key}}').val()) + 1);
                         x=(parseInt($('#number-{{$key}}').val()) *parseFloat($('#price-{{$key}}').text().replace(',','')));

                         $('#total-{{$key}}').number(x,0);

                         a();
                       
                      });

                      $(document).on('click', '.qtyminus-{{$product->id}}', function() {
                        if(parseInt($('#number-{{$key}}').val()) > 1)
                          $('#number-{{$key}}').val(parseInt($('#number-{{$key}}').val()) - 1);
                         $('#total-{{$key}}').number(parseInt($('#number-{{$key}}').val()) *parseFloat($('#price-{{$key}}').text().replace(',','')));

                       a();
                        
                      });
                    </script>
                    @endforeach
                    
                  </tbody>
                </table>
                
                
                <div class="row">
                  <div class="col-md-12 cart-buttons inner-right inner-left">
                    <div class="total__price col-md-12 pull-right text-right">
                      <div class="col-md-55 pull-right row">
                        <p class="0">Thành tiền:<span style="float:right;font-size: 16px;color:red;margin-left: 10px">đ</span><span class="total_price cart-total-price" id="thanhtien">
                        {{number_format($totalPrice)}}</span ><br> <i class="cart_vat">(Đã bao gồm VAT)</i></p> 
                      </div>
                    </div>


                    <div class="clearfix">
                      <div class="vnm-cart-action">
                        <div class="clearfix">
                          <div class="buttons vnm_btn_cart clearfix pull-right">
                            <a href="{{ url('web-bansua/checkout') }}" name="checkout" id="vnm_checkout" class="button-default btn">Thanh toán</a>
                            
                          </div>
                          <div class="pull-right update_cart_wrap">
                            <button class="cart-update-cart">CẬP NHẬT GIỎ HÀNG</button>
                            {{ csrf_field() }}
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-12 inner-left inner-right">
                    <div class="text-left">
                      <a class="continue__buy-product" href="{{route('web-bansua.home')}}"><i class="fa fa-reply"></i> Tiếp tục mua hàng</a>
                    </div>
                    <div class="checkout-buttons clearfix hidden">
                      <label for="note">Ghi chú </label>
                      <textarea id="note" name="note" rows="8" cols="50"></textarea>
                    </div>
                  </div>
                </div>
               
              </form>
            </div>

          </div>
        </div>
        
        <div class="col-md-3">
          <div class="product-right clearfix hidden-xs hidden-sm">
  
            <div class="col-md-12">
              <div class="vnm-list">
                <div class="item">
                  <div class="icon"><img src="{{ asset('images/icon-box-1.png') }}"></div>
                  <div class="text">
                    <div class="text-1">Miễn phí giao hàng</div>
                    <div class="text-2">Đơn hàng 1000000 đ trở lên</div>
                  </div>
                </div>
                <div class="item">
                  <div class="icon"><img src="{{ asset('images/icon-box-2.png') }}"></div>
                  <div class="text">
                    <div class="text-1">Giao hàng nhanh chóng</div>
                  </div>
                </div>
                <div class="item">
                  <div class="icon"><img src="{{ asset('images/icon-box-3.png') }}"></div>
                  <div class="text">
                    <div class="text-1">đảm bảo chất lượng</div>
                    <div class="text-2">Sản phẩm đã được kiểm định</div>
                  </div>
                </div>
                <div class="item">
                  <div class="icon"><img src="{{ asset('images/icon-box-4.png') }}"></div>
                  <div class="text">
                    <div class="text-1">Hỗ trợ</div>
                    <div class="text-2">Hotline: 1900 1000 </div>
                  </div>
                </div>
              </div>
              <div class="vnm-list" style="margin-top:10px;">
                <div class="item">
                  <div class="text">
                    <div class="text-1">Đầy đủ quyền lợi</div>
                  </div>
                  <div class="text-2">Áp dụng Chương trình Khách Hàng thân thiết như mua ở Cửa hàng</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        @else
        <div id="layout-page" class="col-md-12">
          <div class="col-md-12">
            <span class="header-page clearfix">
              <h4 class="cart-title">
                Giỏ hàng của bạn
              </h4>
            </span>
            <p class="text-center no__cart-text">
              Không có sản phẩm nào trong giỏ hàng!
            </p>
            <p class="text-center"><a class="continue__buy-product" href="{{route('web-bansua.home')}}">
              <i class="fa fa-reply"></i> Tiếp tục mua hàng</a>
            </p>
          </div>
        </div>
        @endif

      </div>
      
      </div>
      </div>
    </div>
    </div>

@endsection