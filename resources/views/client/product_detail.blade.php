@extends('layouts.home')
@section('body')
   <br/><br/>
    <div class="container clearfix" style="padding-bottom: 50px">
      <div class="row row_fix_floor" style="margin-bottom: 20px">
        <div class="col-md-12 ">
          <div class="panel-heading chitietsp"><h3>Chi tiết sản phẩm</h3></div>
        </div>
      </div>

      <div class="product__top-detail vnm-wrap-bg">
        <div class="row wrap-product row_fix">
          <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="product-left row_m clearfix">
              <div class="col-md-5">
                <?php $km = number_format($a->discount/$a->giaban*100);?>
                @if($km > 0)
                  <div class="pro-sale">
                    -<?php echo ($km) ;?>%
                  </div>
                @endif
                <div class="product_image">
                  <img id="vnmImage" crossorigin="Anonymous" src="{{ asset('images/'.$a->anh) }}" data-zoom-image="{{ asset('images/'.$a->anh) }}" class="zoom_img img-responsive img_featured" style="max-height: 300px;width: auto">
                  
                  
                  <div class="visible-xs img-mb">
                    <img src="{{ asset('images/'.$a->anh) }}" data-zoom-image="{{ asset('images/noDefaultImage6_master.gif') }}" class="zoom_img img-responsive img_featured_xs" style="max-height: 300px;width: auto">
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
            
                    
                  </div>
                  <div class="row bor-t-mobile">
                    <div class="col-md-12 col-xs-12">
                      <h4 class="text-info">
                      <span>Tình trạng:</span>
                       @if($bool)
                       Còn hàng
                       @else
                       Tạm hết hàng
                       @endif
                      </h4>
                    </div>
                  </div>

                  @if($km > 0)  
                  <div class="row bor-t-mobile">
                    <div class="col-md-12 col-xs-12">
                      <h3 class="product-price">
                      <span>Giá bán:</span>
                        <?php echo number_format($a->giaban-$a->discount).' '; ?><u>đ</u>
                        <del><?php echo number_format($a->giaban).' '; ?><u>đ</u></del>
                        <span class="text-right save-price">Tiết kiệm: <?php echo $km ;?>%</span>
                      </h3>
                    </div>
                  </div>
                  @else
                  <div class="row bor-t-mobile">
                    <div class="col-md-12 col-xs-12">
                      <h3 class="product-price">
                      <span>Giá bán:</span>
                       <?php echo number_format($a->giaban).' ' ?><u>đ</u>
                      </h3>
                    </div>
                  </div>

                  @endif
                  
                  <div class="product-quantity">
                    <label for="quantity">Số lượng: </label>
                    <div class="outer clearfix">
                    <form>
                      <div class="qty_select pull-left">
                        <div class="incrementer vnm-incrementer detail dropdown-toggle1">

                          <input id="quantity" name="quantity" min="1" max="9999" onkeyup="if(this.value>9999){this.value='9999';alert('Bạn chỉ có thể mua tối đa 9999 sản phẩm!');}else if(this.value<1){this.value='1';}" value="1" type="number" class="form-control">
                        </div>
                      </div>
                      <div class="actions pull-left">
                        <div>
                         @if($bool)
                          <span  onclick="dathang({{$a->id}})" class="btn btn-lg btn-primary"><span>Thêm vào giỏ hàng</span></span>@endif
                        </div>
                      </div>
                      </form>
                    </div>
                  </div>
                <div><br></div>

                <div class="wrap_note clearfix">
                  <br>
                  <div class="vnm-alert col-md-6" style="padding-left: 0">
                    <div class="icon"><img src="{{ asset('images/icon_location.png') }}"></div>
                    <div class="text">
                      <div class="text">Giao hàng toàn quốc</div>
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
        
      </div>
    </div>
    <script>
    
      $(document).on('click', '.product-quantity .qtyplus', function() {
        $('#quantity').val(parseInt($('#quantity').val()) + 1);
      });

      $(document).on('click', '.product-quantity .qtyminus', function() {
        if(parseInt($('#quantity').val()) > 1)
          $('#quantity').val(parseInt($('#quantity').val()) - 1);
      });
    </script>
    <script>
      function dathang (id) {
          var url="{{URL::to('web-bansua/addtocart')}}"+"/"+id+"/"+$('#quantity').val();
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
    </script>
      
@stop