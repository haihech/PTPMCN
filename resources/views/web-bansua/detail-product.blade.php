
@extends('web-bansua.index')
@section('css')
  <link href="{{ asset('products/css/style.css') }}" rel="stylesheet">
@section('content')

    <div class="container clearfix">
      <div class="row row_fix_floor">
        <div class="col-md-12 ">
          <div class="panel-heading chitietsp">Chi tiết sản phẩm</div>
        </div>
      </div>

      <div class="product__top-detail vnm-wrap-bg">
        <div class="row wrap-product row_fix">
          <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="product-left row_m clearfix">
              <div class="col-md-5">
                <?php $km = number_format($a->discount/$a->giaban*100) ?>
                @if($km > 0)
                  <div class="pro-sale">
                    -<?php echo $km ?>%
                  </div>
                @endif
                <div class="product_image">
                  
                  <img id="vnmImage" crossorigin="Anonymous" src="{{ asset('images/'.$a->anh) }}" data-zoom-image="{{ asset('images/'.$a->anh) }}" class="zoom_img img-responsive img_featured">
                  
                  
                  <div class="visible-xs img-mb">
                    <img src="{{ asset('images/'.$a->anh) }}" data-zoom-image="{{ asset('images/noDefaultImage6_master.gif') }}" class="zoom_img img-responsive img_featured_xs">
                  </div>
                  
                </div>
                
              </div>
              <div class="col-md-7">
                
                <div class="products-detail">
                  <h4 class="product-name hidden-xs hidden-sm">
                    {{ $a->ten }}
                  </h4>
                  
                  <div class="description-short hidden-xs hidden-sm">
                    <ul  style="list-style-type: square;">
                    {!! $a->mota !!}
                    </ul>
                    <a class="see-more-des" href="#" data-spy="scroll" role="tab">Xem chi tiết</a>
                    
                  </div>
                  
                  @if($a->discount > 0)  
                  <div class="row bor-t-mobile">
                    <div class="col-md-12 col-xs-12">
                      <h3 class="product-price">
                      <span>Giá bán:</span>
                        {{ $a->giaban-$a->discount}}<u>đ</u>
                        <del>{{ $a->giaban }}<u>đ</u></del>
                        <span class="text-right save-price">Tiết kiệm: {{$a->discount}}%</span>
                      </h3>
                    </div>
                  </div>
                  @else
                  <div class="row bor-t-mobile">
                    <div class="col-md-12 col-xs-12">
                      <h3 class="product-price">
                      <span>Giá bán:</span>
                       {{ $a->giaban }}<u>đ</u>
                      </h3>
                    </div>
                  </div>
                  @endif
                  
                  <div class="product-quantity">
                    <label for="quantity">Số lượng: </label>
                    <div class="outer clearfix">
                    <form action="{{ url('addtocart', ['id'=> $a->id]) }}" method="get">
                      <div class="qty_select pull-left">
                        <div class="incrementer vnm-incrementer detail dropdown-toggle1">
                          
                          <button type="button" class="qtyplus" id="qtyplus"><i class="fa fa-caret-up"></i></button>
                          <input id="quantity" name="quantity" min="1" max="9999" onkeyup="if(this.value>9999){this.value='9999';alert('Bạn chỉ có thể mua tối đa 9999 sản phẩm!');}else if(this.value<1){this.value='1';}" value="1" type="number" class="form-control">
                          <button type="button" class="qtyminus" id="qtyminus"><i class="fa fa-caret-down"></i></button>
                          
                        </div>
                      </div>
                      <div class="actions pull-left">
                        <div>
                          <button type="submit" class="btn-popup btn-addToCart1 btn btn-lg btn-primary"><span>Thêm vào giỏ hàng</span></button>
                        </div>
                      </div>
                      </form>
                    </div>
                  </div>
                <div><br></div>

                <div class="wrap_note clearfix">
                  <div class="prod_vnm_note">
                    <p>
                      Thời gian đặt hàng và giao hàng
                    </p>
                    <ul>
                      <li> Đặt hàng trước 9h sáng: giao hàng trong ngày</li>
                      <li> Đặt hàng sau 9h sáng: giao hàng trong ngày hôm sau</li>
                    </ul>
                  </div>
                  <div class="vnm-alert col-md-6" style="padding-left: 0">
                    <div class="icon"><img src="{{ asset('images/icon_location.png') }}"></div>
                    <div class="text">
                      <div class="text">Chỉ giao hàng tại <br> Tp. Hà Nội.</div>
                    </div>
                  </div>
                  
                </div>         
              </div>
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
                    <div class="text-2">Đơn hàng 1 đ trở lên</div>
                  </div>
                </div>
                <div class="item">
                  <div class="icon"><img src="{{ asset('images/icon-box-2.png') }}"></div>
                  <div class="text">
                    <div class="text-1">Giao hàng trong ngày</div>
                    <div class="text-2">Khi đặt trước 9h sáng</div>
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
        
      </div>
    </div>
    </div>

    </script>
    <script>
      $(document).on('click', '.product-quantity .qtyplus', function() {
        $('#quantity').val(parseInt($('#quantity').val()) + 1);
      });

      $(document).on('click', '.product-quantity .qtyminus', function() {
        if(parseInt($('#quantity').val()) > 1)
          $('#quantity').val(parseInt($('#quantity').val()) - 1);
      });
    </script>
    <!-- <script type="text/javascript">
      $(document).ready(function(){
          $.ajax({
            url: '{{ URL::to('products/mota')}}',
            method: GET,
            data:{'motasp':'1'},
            success:function(data){
              alert('1');
              $('#motasp').html(data);
            }
          });
        });
      </script> -->

@endsection