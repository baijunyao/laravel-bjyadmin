<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="{{ url('home/demo/check_captcha') }}" method="post">
    {{ csrf_field() }}
    {!! captcha_img() !!}
    <input type="text" name="captcha" >
    <input type="submit" value="提交">
</form>
</body>
</html>