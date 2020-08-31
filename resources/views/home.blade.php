<?php
//  $http= $_SERVER['HTTP_X_FORWARDED_PROTO'];
// if (!strpos($http, 's') !== false) {
//     $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//      header('Location: ' . $redirect);
//      die();
// }
 ?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title') </title>
    <!-- Favicon-->
    {{--<link rel="icon" href="favicon.ico" type="image/x-icon">--}}

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('/plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{ asset('/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
     <!-- awesome Css -->
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
    

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('/css/themes/all-themes.css') }}" rel="stylesheet" />

    @yield('style')

    <link href="{{ asset('/css/mystyle.css') }}" rel="stylesheet">

</head>

<body class="theme-teal">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Đang tải...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="Nhập thông tin tìm kiếm...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-flprovider_id">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        </div>
       
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</div>
                <div class="email">{{ auth()->user()->email }}</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ route('profile.info') }}"><i class="material-icons">person</i>Tài khoản</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="javascript:;" class="sign_out"><i class="material-icons">input</i>Thoát</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                @include('menu')
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; @php echo date("Y"); @endphp <a href="javascript:void(0);">{{ config('app.name') }}</a>.
            </div>
            <div class="version">
                <b>Version: </b> {{ config('simsogiare.version') }}
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>


<section class="content">
    <div class="container-flprovider_id">
        @yield('content')
    </div>
</section>

<div class="wrap_loader">
    <div class="loader_inner">
        <div class="preloader">
            <div class="spinner-layer pl-teal">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="sign_out" method="POST" action="{{ route('logout') }}">
    {{ csrf_field() }}
</form>

<!-- Jquery Core Js -->
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Select Plugin Js -->
<?php  if(\Request::route()->getName()!='checking_b88.index' && \Request::route()->getName()!='checking_b88.filter' 
&& \Request::route()->getName()!='match_notification_checking.list' && \Request::route()->getName()!='tracking_match_change_b88.list'  && \Request::route()->getName()!='tracking_match_change_188bet.list'):?>
<!-- <script src="{{ asset('/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script> -->
<?php endif ?>
<!-- Slimscroll Plugin Js -->
<!-- <script src="{{ asset('/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script> -->

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('/plugins/node-waves/waves.js') }}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{ asset('/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

<!-- Notifications Plugin Js -->
<script src="{{ asset('/js/pages/ui/notifications.js') }}"></script>

<!-- SweetAlert Plugin Js -->
<script src="{{ asset('/plugins/sweetalert/sweetalert.min.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('/js/admin.js') }}"></script>
<script src="{{ asset('/js/script.js') }}"></script>

<script>
    $(document).ready(function () {
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showNotification('bg-black', '{{ $error }}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
            @endforeach
        @endif

        @if(session('notify'))
                showNotification('bg-green', '{{session('notify')}}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
        @endif

        $('.sign_out').click(function () {
           $('#sign_out').submit();
        });

    });
</script>

<!-- External Js -->
@yield('script')

@include('admin.style')
  <style>
   #dataList .waves-effect.view, #dataList .waves-effect.remove, #dataList .waves-effect.edit,#dataList .waves-effect {
    margin-right: 5px;
    height: 26px;
    width: 26px;
    position: relative;
}
.theme-teal .navbar{
    z-index: 99999;
}
body .sidebar .menu{
    height: 75vh;
}
.note-editor.note-frame.panel i {
    font-size: 12px !important;
}
#dataList .waves-effect .material-icons, #dataList .waves-effect.view .img {
    font-size: 15px !important;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
}
#dataList .waves-effect .material-icons, #dataList .waves-effect.view .img {
    font-size: 15px !important;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
}
.waves-effect.view .img {
    width: 15px;
}
        span.blue.match_result {
            color: #3eb005;
        }
        span.red.match_result {
            color: red;
        }
        body .standings-league.active .standings-items{
            max-height: 2200px !important
        }
         body .module_search a{
            background:#d6c700 ;
        }
        .flex{
            display: flex ;
            display: -ms-flex ;
            display: -moz-flex ;
            display: -webkit-flex ;
            align-items: center;
            -webkit-align-items:center;
            justify-content: space-between;
            -webkit-justify-content: space-between;
        }
        .footer-fixed .item i{
            font-size: 16px
        }
        .footer-fixed{
            width: 100%;
            text-align: center;
            margin: auto;
            background: #ed1c24;
            position: fixed;
            bottom: 0px;
            z-index: 9999;
        }
        .footer-fixed .item {
            border-right: 1px solid #ededed;
            text-align: center;
            width: 20%;
            padding: 0px 0 0px;
        }
        ul.ml-menu.language .active a{
            color: #000;
            font-weight: bold;
        }
        .category_item_input {
    margin-top: 2px !important;
    margin-right: 8px !important;
    position: relative;
    top: 2px;
}
.float-right {
    float: right;
}
.postbox {
    padding: 20px;
    padding-bottom: 10px;
}
.postbox .title {
    font-size: 16PX;
    text-transform: uppercase;
    font-weight: bold;
}
.postbox #post-visibility-select {
    margin-bottom: 7px;
}
.radio, .checkbox {
    position: relative !important;
    left: 0px !important;
    opacity: 1 !important;
    display: inline-block;
}
        .footer-fixed .item:last-child{
            border-right:none;
        }
        .footer-fixed .item:nth-child(2),.footer-fixed .item:nth-child(4){
            background: rgb(1, 103, 3);
        }
        .package_item[data-id="11"]{
            background: rgb(1, 103, 3) !important
        }
         .package_item[data-id="11"]:hover, .package_item[data-id="11"].active{
                background: #3eb005 !important;
        }
        .package_item[data-id="12"]{
            background: #c1a606 !important;
        }
         .package_item[data-id="12"]:hover, .package_item[data-id="12"].active{
            background: #f6d71f !important
        }
        .footer-fixed .link_title  {
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-decoration: none;
            display: block;
            height: 25px;
            padding-top: 5px;
        }
       
        .mobile{
            display: none;
        }
      
        .fixedmenuhome .nav-inline {
            width: 300px;
        }
        .fixedmenuhome > ul > li {
            position: relative;
        }
        .fixedmenuhome > ul > li:before {
            content: '';
            -webkit-transition: all 0.5s ease-in-out;
            -khtml-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
            background: #016703;
            width: 0;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }
        .fixedmenuhome > ul > li > a {
            display: block;
            color: #fff;
            line-height: 45px;
            padding: 0 10px;
            font-size: 18px;
            border-bottom: 1px solid #fff;
            position: relative;
            z-index: 2;
        }
        
        .fixedmenuhome > ul > li > a i.fa-telegram {
            color: #fff;
        }
        .fixedmenuhome > ul > li > a i {
            font-size:18px;
            line-height: 2rem;
            margin-right: .5rem;
        }
        .fixedmenuhome > ul > li.fb i{
            margin-left: 4px;
        }
        .fixedmenuhome > ul > li > a:hover, .fixedmenuhome > ul > li > a:focus, .fixedmenuhome > ul > li > a:visited, .fixedmenuhome > ul > li > a:active {
            background: #016703;
        }
        i.fa.fa-telegram:before {
            content: "\f2c6";
        }
        .fixedmenuhome > ul > li > a {
            padding-right: 0 !important;
        }
        .fixedmenuhome {
                width: 300px;
            background: rgb(214, 199, 0);
            -webkit-transition: all 0.5s ease-in-out;
            -khtml-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        .fixedmenuhome > ul > li:last-child > a{
            border-bottom: none
        }
        @media screen and (max-width: 767px){
            .pc{
                display: none;
            }
            body .container-flprovider_id .bars:after, body .container-flprovider_id .bars:before{
                top: 0px !important;
                left: 0 !important;
                width: 30%;
                height: 100%;
                padding-top: 8px;
                padding-left: 15px;
                margin-right: 0;
            }
            .pagination > li > a, .pagination > li > span{
                padding: 2px 8px;
            }
            div.dataTables_wrapper div.dataTables_info{
                font-size: 10px
            }
            .mobile{
                display: block;
            }
            .footer-fixed{
              display: flex ;
                display: -ms-flex ;
                display: -moz-flex ;
                display: -webkit-flex ;
            }
            body .col-xs-12{
                padding-right: 5px;
                padding-left: 5px;
            }
            body table.dataTable thead > tr > th,body table.dataTable thead > tr > td,
            body .table-bordered tbody tr td,body .table-bordered tbody tr th{
                padding-right: 2px;
                width: 100px;
                padding-left: 2px;
            }
           
            .info-box .icon{
                width: 65px;
            }
            .info-box .content .text{
                margin-top: 8px;
            }
            .info-box .icon i{
                font-size: 35px;
                line-height: 65px;
            }
            .info-box .content .number {
                font-size: 18px;
                margin-top: 2px;
            }
            body .info-box {
                height: 65px;
            }
            body section.content{
                margin: 70px 15px 0 315px;
            }            
            
            .card [id*=List] [type="checkbox"] + label {
                padding: 5px 5px 16px;
            }
            [type="checkbox"].filled-in:not(:checked) + label:after ,[type="checkbox"] + label:before, [type="checkbox"]:not(.filled-in) + label:after{
                height: 10px;
                width: 10px;
            }
            body #dataList thead tr th:last-child,body #dataList tbody tr td:last-child{
                max-width: 20px !important;   
                 width: 20px !important;
            }
            #dataList .material-icons{
                font-size: 10px;
                top: 1px;
            }
            body .navbar .navbar-header{
                padding: 0px 7px;
            }
            body .sidebar{
                width: 250px;
                top: 50px;
            }
            body .bars:before , body .bars:after  {
                top: 8px !important;
            }
            body .navbar{
                margin: 0;
                padding: 0
            }
            body .sidebar .user-info{
                height: 60px;
                padding: 12px 15px 12px 15px;
            }
            body .module_search a{
                right: 0px;
            }
            body #dataList_wrapper .col-sm-6{
                padding: 0;
                margin: 0;
                font-size: 10px;
            }
            body .card .body{
                padding: 8px;
            }
            body .table-bordered tbody tr td,body .table-bordered tbody tr th,body .table thead tr th,body .table tfoot tr th{
                font-size: 8.5px;
                padding: 5px 2px;
            }
            body .sidebar .user-info .info-container .user-helper-dropdown{
                bottom: 0px;
            }
            body .module_search .row {
                margin:0px; 
            }
            body .module_search .row .col-xs-12{
                padding: 0
            }
            body #collapseWrap .card .body{
                padding: 22px;
            } 
            body #collapseWrap .form-group{
                padding: 20px;
                margin-bottom: 0;
            }
            .package_selected strong{
                font-size: 16px !important
            }
        }
  </style>
</body>
</html>