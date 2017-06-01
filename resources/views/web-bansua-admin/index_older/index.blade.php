<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sua</title>
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('web-bansua-admin/style.css') }}">
    <link href="{{ asset('font-awesome-4.6.3/css/font-awesome.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <link href="{{ asset('css/jquery.ui.autocomplete.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{!! asset('js/ckeditor/ckeditor.js') !!}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dataTable/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dataTable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
          $(function () {
            $('.datepicker').datepicker({ format: "dd//mm/yyyy" }).on('changeDate', function (ev) {
              $(this).datepicker('hide');
            });
          });   
    </script>
  </head>
  <body>

      <header>

        <nav class="navbar navbar-default navbar-static-top navbar-fix-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">SUA Admin</a>                
            </div>
            <div class="login">
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> {{ Session::has('admin') ? Session::get('admin')->ten : '' }} 
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Tài khoản</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Cài đặt</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('logout-admin') }}"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a>
                        </li>
                    </ul>
                </li>
            </ul>
            </div></nav>
           
    </header>

      <div class="row  affix-row">
        <div class="col-sm-3 col-md-2 affix-sidebar">
        <div class="sidebar-nav">
        <div class="navbar navbar-default side-nav" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">Sidebar menu</span>
          </div>
          <div class="navbar-collapse abc collapse sidebar-navbar-collapse" >
            <ul class="nav navbar-nav" id="sidenav01">
              
              @if(strpos(Session::get('str_roles'),"quyen-15") !== false)
              <li style="font-size: 15px" >
                <a href="#" data-toggle="collapse" data-target="#toggleDemo2" data-parent="#sidenav01" class="collapsed">
                <i class="fa fa-product-hunt menu-hinh" aria-hidden="true"></i>&nbsp;Sản phẩm</i><i class="fa fa-fw fa-caret-down"></i>
                </a>
                <div class="collapse" id="toggleDemo2" style="height: 0px;">
                  <ul class="nav nav-list"  style="font-size: 14px">
                    
                    @foreach(Session::get('role') as $role)
                        @if($role->role_id == 'quyen-15')
                        <li><a href=" {{route('timkiemsanpham')}}">Tìm kiếm</a></li>
                        <li><a href="{{ url('trademark') }}">Thương hiệu</a></li>
                        <li><a href="{{ url('age-group') }}">Nhóm tuổi</a></li>
                        <li><a href="{{ route('quanlysanpham') }}">Quản lý sản phẩm</a></li>
                        @endif
                    @endforeach
                  </ul>
                </div>
              </li>
              @else
                <li @if(Session::get('active') == 'sanpham') class="active" @endif style="font-size: 15px"><a href=" {{route('timkiemsanpham')}}"><i class="fa fa-product-hunt menu-hinh" aria-hidden="true"></i>&nbsp;Sản phẩm</a></li>
              @endif



              @if(strpos(Session::get('str_roles'),"quyen-01") !== false)
              <li style="font-size: 15px" >
                <a href="javascript:;" data-toggle="collapse" data-target="#toggleDemo3" data-parent="#sidenav01" class="collapsed" aria-expanded="">
                <i class="fa fa-bars menu-hinh" aria-hidden="true"></i>&nbsp;Đơn hàng<i class="fa fa-fw fa-caret-down"></i>
                </a>
                <div class="collapse" id="toggleDemo3" style="height: 0px;">
                  <ul class="nav nav-list active" style="font-size: 14px">
                    @foreach(Session::get('role') as $role)
                        @if($role->role_id == 'quyen-01')
                        <li><a href="{{ url('tim-kiem-don-hang') }}">Tìm kiếm</a></li>
                        <li><a href="{{ route('choxuly') }}">Chờ xử lý</a></li>
                        <li><a href="{{ route('confirmed') }}">Đã xác nhận</a></li>
                        <li><a href="{{ route('daxuatkho') }}">Xuất kho gửi khách hàng</a></li>
                        <li><a href="{{ route('dahoanthanh') }}">Hoàn thành</a></li>
                        @endif
                        
                    @endforeach
                    
                  </ul>
                </div>
              </li>
              @else
                <li @if(Session::get('active') == 'donhang') class="active" @endif  style="font-size: 15px"><a href="{{ url('tim-kiem-don-hang') }}"><i class="fa fa-product-hunt menu-hinh" aria-hidden="true"></i>&nbsp;Đơn hàng</a></li>
              @endif

              @if(strpos(Session::get('str_roles'),"quyen-03") !== false)
              <li style="font-size: 15px">
                <a href="javascript:;" data-toggle="collapse" data-target="#toggleDemo6" data-parent="#sidenav01" class="collapsed" aria-expanded="">
                <i class="fa fa-exchange menu-hinh" aria-hidden="true"></i>&nbsp;Nhập - Xuất<i class="fa fa-fw fa-caret-down"></i>
                </a>
                <div class="collapse" id="toggleDemo6" style="height: 0px;">
                  <ul class="nav nav-list active" style="font-size: 14px">
                    @foreach(Session::get('role') as $role)
                        @if($role->role_id == 'quyen-03')
                        <li><a href=" {{ route('xuathang') }}">Xuất hàng</a></li>
                        <li><a href="{{ route('import') }}">Nhập hàng</a></li>
                        <li><a href="{{ route('import_return') }}">Hoàn kho</a></li>
                        <li><a href="{{ route('danhsachnhapxuat') }}">Danh sách nhập xuất</a></li>
                        @endif
                        
                    @endforeach
                    
                  </ul>
                </div>
              </li>
              @endif

              @if(strpos(Session::get('str_roles'),"quyen-08") !== false)
              <li style="font-size: 15px">
                <a href="javascript:;" data-toggle="collapse" data-target="#toggleDemo7" data-parent="#sidenav01" class="collapsed" aria-expanded="">
                <i class="fa fa-credit-card menu-hinh" aria-hidden="true"></i>&nbsp;Thu - Chi<i class="fa fa-fw fa-caret-down"></i>
                </a>
                <div class="collapse" id="toggleDemo7" style="height: 0px;">
                  <ul class="nav nav-list active" style="font-size: 14px">
                    @foreach(Session::get('role') as $role)
                        @if($role->role_id == 'quyen-08')
                        <li><a href="{{ route('thutien') }}">Tạo phiếu thu</a></li>
                        <li><a href="{{ route('chitien') }}">Tạo phiếu chi</a></li>
                        <li><a href="{{ route('danhsachthuchi') }}">Danh sách thu chi</a></li>
                        @endif
                        
                    @endforeach
                    
                  </ul>
                </div>
              </li>
              @endif


              @if(strpos(Session::get('str_roles'),"quyen-02") !== false)
                <li @if(Session::get('active') == 'khachhang') class="active" @endif style="font-size: 15px"><a href="{{route('danhsachkhachhang')}}"><i class="fa fa-user menu-hinh" aria-hidden="true"></i>&nbsp;Khách hàng</a></li>
              @endif

              @if(strpos(Session::get('str_roles'),"quyen-14") !== false)
                <li @if(Session::get('active') == 'nhacungcap') class="active" @endif style="font-size: 15px"><a href="{{route('danhsachnhacungcap')}}"><i class="fa fa-car menu-hinh" aria-hidden="true"></i>&nbsp;Nhà cung cấp</a></li>
              @endif
               
              @if(strpos(Session::get('str_roles'),"quyen-12") !== false)
              <li @if(Session::get('active') == 'taikhoan') class="active" @endif style="font-size: 15px"><a href="{{route('danhsachnhanvien')}}"><i class="fa fa-user-plus menu-hinh" aria-hidden="true"></i>&nbsp;Tài khoản</a></li>
              @endif

              @if(strpos(Session::get('str_roles'),"quyen-05") !== false || strpos(Session::get('str_roles'),"quyen-04") !== false)
              <li style="font-size: 15px">
                <a href="javascript:;" data-toggle="collapse" data-target="#toggleDemo8" data-parent="#sidenav01" class="collapsed" aria-expanded="">
                <i class="fa fa-bug menu-hinh" aria-hidden="true"></i>&nbsp;Thống kê<i class="fa fa-fw fa-caret-down"></i>
                </a>
                <div class="collapse" id="toggleDemo8" style="height: 0px;">
                  <ul class="nav nav-list active" style="font-size: 14px">
                    @foreach(Session::get('role') as $role)
                        @if($role->role_id == 'quyen-05')
                        <li><a href="{{ route('danhsachnhacungcap') }}">Thống kê hàng hóa</a></li>
                        @endif
                        @if($role->role_id == 'quyen-05')
                        <li><a href="{{ route('danhsachnhacungcap') }}">Thống kê doanh số</a></li>
                        @endif
                        
                    @endforeach
                    
                  </ul>
                </div>
              </li>
              
              @endif
              
              
            </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>

        </div>
      
        <div class="col-sm-9 col-md-10 affix-content">
          @yield('content')
        </div>
      </div>
    
  </body>
</html>

