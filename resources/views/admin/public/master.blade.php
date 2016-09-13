<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title') - bjyadmin</title>
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('/statics/bootstrap-3.3.5/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/statics/font-awesome-4.4.0/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('/css/public/base.css')}}" />
    @yield('css')
</head>
<body>
<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <a href="{:U('Admin/Index/index')}"><i class="fa fa-home"></i> 首页</a>
    &gt;
    @yield('nav')
</div>

@yield('body')


<!-- 引入bootstrjs部分开始 -->
<script src="{{asset('/statics/js/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('/statics/bootstrap-3.3.5/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/public/base.js')}}"></script>
@yield('js')
</body>
</html>
