<!DOCTYPE html>
<html>
<head>
  <title>App Name - @yield('title','首页')</title>
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no" />
  <meta name="format-detection" content="email=no" />
  {!! yCsrfTag() !!}
  {!! yCssFile('@web/static/css/weui.css?v='.env('ASSET_VERSION'))!!}
  {!! yCssFile('@web/static/css/jquery-weui.css?v='.env('ASSET_VERSION'))!!}
  {!! yCssFile('@web/static/css/common.css?v='.env('ASSET_VERSION'))!!}
  {!! yJsFile('@web/static/js/flexible.js?v='.env('ASSET_VERSION'))!!}
  {!! yJsFile('@web/static/js/jquery-2.1.4.min.js?v='.env('ASSET_VERSION'))!!}
  @yield('head-script')
  <script>
      var PATH_INFO = '{{yRequest()->getPathInfo()}}';
      var SITE_URL = '{{rtrim(yUrl(['/'], true), '/')}}';
      var CURRENT_URL = '{{yUrlRoute([''], true)}}';
  </script>
</head>
<body>
@yield('content')
{!! yJsFile('@web/static/js/jquery-weui.js?v='.env('ASSET_VERSION')) !!}
{!! yJsFile('@web/static/js/common.min.js?v='.env('ASSET_VERSION')) !!}
@yield('foot-script')
</body>
</html>
