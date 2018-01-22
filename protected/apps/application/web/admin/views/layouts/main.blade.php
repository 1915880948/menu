<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>小菜谱 | @yield('title','')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{yStatic('1.ico')}}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Morris chart -->
    {{--<link rel="stylesheet" href="{{yStatic('vendor/bower_components/morris.js/morris.css')}}">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{yStatic('vendor/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{yStatic('vendor/dist/css/skins/_all-skins.min.css')}}">
    <!-- jvectormap -->
    {{--<link rel="stylesheet" href="{{yStatic('vendor/bower_components/jvectormap/jquery-jvectormap.css')}}">--}}
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    {{--<link rel="stylesheet" href="{{yStatic('vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">--}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">--}}

    @yield('head-style')
    @stack('head-script')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{yUrl(['index'])}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>M</b>enu</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Menu</b>管理后台</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{yStatic('vendor/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ yUserIdentity()->username  }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{yUrl(['site/logout'])}}" data-method="post" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{yStatic('vendor/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ yUserIdentity()->username  }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">菜单导航</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-tags"></i> <span>菜单标签</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['tag/index'])}}"><i class="fa fa-circle-o"></i>标签列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-list-ol"></i> <span>食疗分类</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['type/index'])}}"><i class="fa fa-circle-o"></i>分类列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file-text-o"></i> <span>菜单管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['menu/index'])}}"><i class="fa fa-circle-o"></i> 菜单列表</a></li>
                        <li><a href="{{yUrl(['menu/edit'])}}"><i class="fa fa-circle-o"></i> 添加菜单</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cny"></i> <span>订单管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['order/index'])}}"><i class="fa fa-circle-o"></i> 订单列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-plus"></i> <span>用户管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['users/index'])}}"><i class="fa fa-circle-o"></i> 用户列表</a></li>
                    </ul>
                </li>
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-pie-chart"></i> <span>食材管理</span>--}}
                        {{--<span class="pull-right-container">--}}
                            {{--<i class="fa fa-angle-left pull-right"></i>--}}
                        {{--</span>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{yUrl(['ingredients/index'])}}"><i class="fa fa-circle-o"></i> 食材列表</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>


    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{--<script>--}}
    {{--$.widget.bridge('uibutton', $.ui.button);--}}
{{--</script>--}}

<!-- jQuery 3 -->
<script src="{{yStatic('vendor/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{yStatic('vendor/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{yStatic('vendor/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- jvectormap -->
{{--<script src="{{yStatic('vendor/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>--}}
{{--<script src="{{yStatic('vendor/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
<!-- jQuery Knob Chart -->
{{--<script src="{{yStatic('vendor/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>--}}

<!-- Morris.js charts -->
{{--<script src="{{yStatic('vendor/bower_components/raphael/raphael.min.js')}}"></script>--}}
{{--<script src="{{yStatic('vendor/bower_components/Chart.js/Chart.js')}}"></script>--}}
{{--<script src="{{yStatic('vendor/bower_components/morris.js/morris.min.js')}}"></script>--}}
<!-- Sparkline -->
{{--<script src="{{yStatic('vendor/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>--}}


<!-- daterangepicker -->
<script src="{{yStatic('vendor/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{yStatic('vendor/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{yStatic('vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{yStatic('vendor/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
{{--<script src="{{yStatic('vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>--}}
<!-- Slimscroll -->
<script src="{{yStatic('vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{yStatic('vendor/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{yStatic('vendor/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{yStatic('vendor/dist/js/pages/dashboard.js')}}"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="{{yStatic('vendor/dist/js/demo.js')}}"></script>
<script src="{{yStatic('app.js')}}"></script>
<!-- baidu echarts -->
{{--<script src="{{yStatic('vendor/dist/baidu/dist/echarts.min.js')}}"></script>--}}
{{--<script src="{{yStatic('vendor/dist/baidu/dist/china.js')}}"></script>--}}
<!-- layer js -->
<script src="{{yStatic('vendor/layer/layer.js')}}"></script>

<script>
    $(function(){
        $('a[href="'+window.location.pathname+'"]').parent('li').addClass('active').parents('li').addClass('active').addClass('menu-open');
    });
</script>
@stack('foot-script')
</body>
</html>

