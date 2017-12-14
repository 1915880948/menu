<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{yApp('name')}} | 用户登录</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="refresh" content="{{$time}};URL={{yUrl($url)}}">
    <link rel="stylesheet" href="{{yStatic('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="http://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{yStatic('vendor/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{yStatic('vendor/plugins/iCheck/flat/blue.css')}}">
    <!--[if lt IE 9]>
    <script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="http://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <h1>
            &nbsp; </h1>
    </div>
    <div class="box box-solid box-{{$mode}}">
        <div class="box-header">
            <h3 class="box-title"> {{$title}}</h3>
        </div>
        <div class="box-body text-center">
            <h1></h1>
            {{$message}}
            <h1></h1>
        </div>
        <div class="box-footer text-right">
            <a href="{{yUrl($url)}}">如果{{$time}}秒没有跳转，点击跳转</a>
        </div>
    </div>
</div>
</body>
</html>
