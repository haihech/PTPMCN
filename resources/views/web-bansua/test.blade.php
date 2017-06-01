<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Sua</title>
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
		<link href="font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
	</head>
	<body>
		<header>
        <nav class="navbar navbar-default bg-header">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img alt="Brand" src="images/brand.png"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav menu">
                  <li><a href="#"><span class="glyphicon glyphicon-home"></span> Trang chủ</a></li>
                  <li><a href="#"><span class="glyphicon glyphicon-education"></span> Sản phẩm</a></li>
                  <li><a href="#"><i class="fa fa-book" aria-hidden="true"></i> Đơn hàng</a></li>
                  <li><a href="#"><i class="fa fa-cube" aria-hidden="true"></i> Giới thiệu</a></li>
              </ul>

              <form class="navbar-form navbar-left">
                  <div class="input-group">
                      <div class="ui-widget">
                        <input type="text" id="search" class="form-control" placeholder="Tìm kiếm...">
                        <div class="dropdown-menu" id="productList"></div>
                      </div>
                            
                  </div>
                  <div class="input-group">
                    <span class="input-group-btn">
                          <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i>
                          </button>
                        </span>  
                  </div>
              </form>
              <ul class="nav navbar-nav navbar-right menu">
                <li><a href="#"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> Giỏ hàng (<span id="count_item">0</span>)<br /> <span class="cart-price">0₫</span></a></li>

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tài khoản<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                        <li><a href="{{ url('web-bansua/signin')}}" class="btn" role="button">Đăng nhập</a></li>
                        <li><a href="{{ url('web-bansua/signup') }}" class="btn" role="button">Đăng ký</a></li>
                        
                        <li class="divider" role="separator"></li>
                        <li><a href="#" class="btn" role="button">Đăng xuất</a></li>
                                   
                  </ul>
                </li>

              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </header>
     
    <div class="container">
      <div class="main">
        <div class="row">
          <h1>Test hai</h1>
        </div>
      </div>
      
    </div>

    <div class="back_top"> <a class="btn-top" href="javascript:void(0);" title="Top" style="display: inline;"></a> 
    </div>
    
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $('#search').on('keyup',function(){
        $value = $(this).val();
        $.ajax({
            url:'{{URL::to('web-bansua/home/search')}}',
            method: "GET",
            data:{'search':$value},
            success:function(data){
              $('#productList').fadeIn();
              $('#productList').html(data);
            }
          });
      });
      $(document).on('click','li', function(){
        $datas = $('#productList').html();
        if($datas.includes($(this).text())){
          $('#search').val($(this).text());
          $('#productList').fadeOut();
        }
      });
      
    </script>
	</body>
</html>







<div class="product__top-detail vnm-wrap-bg">
        <div class="row wrap-product row_fix">
          <div class="col-xs-12 visible-xs visible-sm">
            <div class="col-xs-1">
            </div>
            <div class="col-xs-12 text-center">
              <h4 class="product-name">
                Sữa bột Dielac Alpha Gold Step 3 - Hộp thiếc 1,5kg
              </h4>
            </div>
            
          </div>
          <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="product-left row_m clearfix">
              <div class="col-md-5">

                <div class="pro-gift hidden" product-id="1003474877"></div>
                <div class="product_images">
                  
                  <img id="vnmImage" crossorigin="Anonymous" src="//sw001.hstatic.net/8/1356f35b776efa/dielac_alpha_step_3_ht_1.5kg-01_grande.jpg" data-zoom-image="//sw001.hstatic.net/8/1356f35b776efa/dielac_alpha_step_3_ht_1.5kg-01_grande.jpg" class="zoom_img img-responsive img_featured">
                  
                  
                  <div class="visible-xs img-mb">
                    <img src="//sw001.hstatic.net/8/1356f35b776efa/dielac_alpha_step_3_ht_1.5kg-01_grande.jpg" data-zoom-image="//hstatic.net/0/0/global/noDefaultImage6_master.gif" class="zoom_img img-responsive img_featured_xs">
                  </div>
                  
                </div>
                
              </div>
              <div class="col-md-7">
                
                <div class="products-detail">
                  <h4 class="product-name hidden-xs hidden-sm">
                    Sữa bột Dielac Alpha Gold Step 3 - Hộp thiếc 1,5kg
                  </h4>
                  
                  <div class="description-short hidden-xs hidden-sm">
                    
                    
                    <ul style="list-style-type: square;">
<li>Quy cách thùng: 6 hộp/thùng</li>
<li>Dielac Alpha Gold đặc chế hỗ trợ phát triển trí não với công thức Opti-Grow IQ™</li>
<li>Sản phẩm ứng dụng thành công Lutein từ nghiên cứu của tập đoàn dinh dưỡng DSM, Thụy Sĩ</li>
<li>Bổ sung Lutein với hàm lượng DHA tăng gấp đôi cùng các dưỡng chất thiết yếu khác như ARA, Cholin, Omega 3, Omega 6 theo các tiêu chuẩn quốc tế</li>
</ul>
                    <a class="see-more-des" href="#motasanpham" data-spy="scroll" role="tab">Xem chi tiết</a>
                    
                  </div>
                  
                  
                  <div class="row bor-t-mobile">
                    <div class="col-md-12 col-xs-12">
                      <h3 class="product-price" theme="" syntax="" error="">
                        <span class="hidden-xs hidden-sm">Giá:</span> 280,500₫
                        
                      </h3>
                    </div>
                  </div>
                  
                  <select id="product-select" name="id" style="display:none" class="hidden">
                    
                    <option value="1009104372">Default Title - 280,500₫</option>
                    
                  </select>
                  
                  
                  <div class="product-quantity">
                    <label for="quantity">Số lượng: </label>
                    <div class="outer clearfix">
                      <div class="qty_select pull-left">
                        <div class="incrementer vnm-incrementer detail dropdown-toggle" data-max-value="16">
                          
                          <button type="button" class="qtyplus"><i class="fa fa-caret-up"></i></button>
                          <input id="quantity" name="quantity" min="0" max="999" onkeyup="if(this.value>999){this.value='999';alert('Bạn chỉ có thể mua tối đa 999 sản phẩm!');}else if(this.value<0){this.value='0';}" value="1" type="number" class="form-control">
                          <button type="button" class="qtyminus"><i class="fa fa-caret-down"></i></button>
                          <div class="vnm_alert_quantity tooltip bottom hide">
                            <div class="tooltip-arrow"></div>
                            <div class="tooltip-inner">Xin vui lòng nhập ít nhất 1 sản phẩm</div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="actions pull-left">
                        <div>
                          <button type="button" onclick="themvaogio();" class="btn-popup btn-addToCart1 btn btn-lg btn-primary"><span>Thêm vào giỏ hàng</span></button>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <div class="alert alert-warning fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                  Chính sách mua hàng: Đơn hàng đặt trực tuyến phải có giá trị tối thiểu sau khuyến mãi ≥ 300,000 VNĐ
                </div>
                
                <div id="buyxgety-program" class="hidden">
                  <h3 id="buyxgety-themvaogioheader">
                    Các sản phẩm được tặng kèm
                  </h3>
                  <div id="buyxgety-product-list">
                    <table></table>
                  </div>
                  <div class="sp sp-circle hide"></div>
                  <img class="gift" src="">
                </div>
                
                <div class="wrap_note clearfix">
                  <div class="prod_vnm_note">
                    <p>
                      Thời gian đặt hàng và giao hàng
                    </p>
                    <ul>
                      <li>- Đặt hàng trước 10h sáng: giao hàng trong ngày</li>
                      <li>- Đặt hàng sau 10h sáng: giao hàng trong ngày hôm sau</li>
                    </ul>
                  </div>
                  <div class="vnm-alert col-md-6" style="padding-left: 0">
                    <div class="icon"><img src="//hstatic.net/072/1000074072/1000174395/icon_location.png?v=780"></div>
                    <div class="text">
                      <div class="text">Chỉ giao hàng tại <br> Tp. Hồ Chí Minh.</div>
                    </div>
                  </div>
                  <div class="vnm-alert col-md-6 view_list_stores_link">
                    <div class="icon"><img src="//hstatic.net/072/1000074072/1000174395/icon_shop.png?v=780"></div>
                    <div class="text">
                      <div class="text"><a href="/pages/he-thong-cua-hang">Xem danh sách cửa hàng gần khu vực của bạn</a></div>
                    </div>
                  </div>
                </div>         
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-3 col-sm-12 col-xs-12">
          <div class="product-right clearfix hidden-xs hidden-sm">
  
  <div class="col-md-12">
    <div class="vnm-list">
      <div class="item">
        <div class="icon"><img src="//hstatic.net/072/1000074072/1000174395/icon-box-1.png?v=780"></div>
        <div class="text">
          <div class="text-1">Miễn phí giao hàng</div>
          <div class="text-2">Đơn hàng 300.000 đ trở lên</div>
        </div>
      </div>
      <div class="item">
        <div class="icon"><img src="//hstatic.net/072/1000074072/1000174395/icon-box-2.png?v=780"></div>
        <div class="text">
          <div class="text-1">Giao hàng trong ngày</div>
          <div class="text-2">Khi đặt hàng trước 10h sáng</div>
        </div>
      </div>
      <div class="item">
        <div class="icon"><img src="//hstatic.net/072/1000074072/1000174395/icon-box-3.png?v=780"></div>
        <div class="text">
          <div class="text-1">đảm bảo chất lượng</div>
          <div class="text-2">Sản phẩm đã được kiểm định</div>
        </div>
      </div>
      <div class="item">
        <div class="icon"><img src="//hstatic.net/072/1000074072/1000174395/icon-box-4.png?v=780"></div>
        <div class="text">
          <div class="text-1">Hỗ trợ</div>
          <div class="text-2">Hotline: 1900 636 979 </div>
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