<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>数据统计 | @yield('title','')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{yStatic('favicon.ico')}}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/morris.js/morris.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{yStatic('vendor/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{yStatic('vendor/dist/css/skins/_all-skins.min.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/jvectormap/jquery-jvectormap.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{yStatic('vendor/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{yStatic('vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @stack('head-style')
    @stack('head-script')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{yUrl(['index'])}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>D</b>ata</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Data</b>Total</span>
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
                        <i class="fa fa-folder"></i> <span>项目</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['project/index'])}}"><i class="fa fa-line-chart"></i>趋势图</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-firefox"></i> <span>浏览器数据</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['browser/index'])}}"><i class="fa fa-pie-chart"></i>图表</a></li>
                        <li><a href="{{yUrl(['browser/list'])}}"><i class="fa fa-table"></i>列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-tree"></i> <span>Docu数据</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['docu/index'])}}"><i class="fa fa-circle-o"></i>图表</a></li>
                        <li><a href="{{yUrl(['docu/list'])}}"><i class="fa fa-circle-o"></i> 列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span>分享数据</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['shares/index'])}}"><i class="fa fa-circle-o"></i>图表</a></li>
                        <li><a href="{{yUrl(['shares/list'])}}"><i class="fa fa-circle-o"></i> 列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-hand-o-up"></i> <span>导航点击数据</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['sidebar/index'])}}"><i class="fa fa-circle-o"></i>图表</a></li>
                        <li><a href="{{yUrl(['sidebar/list'])}}"><i class="fa fa-circle-o"></i> 列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>用户访问量</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{yUrl(['visituser/index'])}}"><i class="fa fa-circle-o"></i>图表</a></li>
                        <li><a href="{{yUrl(['visituser/list'])}}"><i class="fa fa-circle-o"></i> 列表</a></li>
                    </ul>
                </li>
                {{--<li class="header">LABELS</li>--}}
                {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
                {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
                {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
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
<script src="{{yStatic('vendor/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{yStatic('vendor/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{yStatic('vendor/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>

<!-- Morris.js charts -->
<script src="{{yStatic('vendor/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{yStatic('vendor/bower_components/Chart.js/Chart.js')}}"></script>
<script src="{{yStatic('vendor/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{yStatic('vendor/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>


<!-- daterangepicker -->
<script src="{{yStatic('vendor/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{yStatic('vendor/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{yStatic('vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{yStatic('vendor/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{yStatic('vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{yStatic('vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{yStatic('vendor/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{yStatic('vendor/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{yStatic('vendor/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{yStatic('vendor/dist/js/demo.js')}}"></script>
<script src="{{yStatic('app.js')}}"></script>
<!-- baidu echarts -->
<script src="{{yStatic('vendor/dist/baidu/dist/echarts.min.js')}}"></script>
<script src="{{yStatic('vendor/dist/baidu/dist/china.js')}}"></script>
<!-- layer js -->
<script src="{{yStatic('vendor/layer/layer.js')}}"></script>

<script>
    $(function(){
        var li_index = localStorage.getItem('li_index');
        var ul_index = localStorage.getItem('ul_index');
        if( li_index && ul_index ){
            $('.main-sidebar .sidebar-menu .treeview').removeClass('active');
            $('.main-sidebar .sidebar-menu .treeview .treeview-menu li').removeClass('active');

            $('.main-sidebar .sidebar-menu').find('.treeview').eq(ul_index-1).addClass('active');
            $('.main-sidebar .sidebar-menu').find('.treeview').eq(ul_index-1).find('li').eq(li_index).addClass('active');
        }
        $('.main-sidebar .sidebar-menu .treeview .treeview-menu>li').click(function(){
            var _this = $(this);
            localStorage.setItem('li_index', _this.index());
            localStorage.setItem('ul_index', _this.parent().parent('.treeview').index());
        })
    });
</script>
@stack('foot-script')
</body>
</html>

