<!DOCTYPE html>
<html lang="en" ng-cloak>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="no-cache">
  <meta http-equiv="Expires" content="-1">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0">
  <title>Login/Logout animation concept</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  
  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Open+Sans'>
  <link rel="stylesheet" href="{{URL::to('assets/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{URL::to('assets/custom/login/login.css')}}">
  <base href="/">
</head>
<body>
  <div class="cont">
  <div class="demo">
    <div class="login">
      <div ng-view></div>
    </div>
  </div>
</div>
<script type="text/ng-template" id="login.signin.signin">
  @include('login.signin.signin')
</script>
<script data-main="{{URL::to('js/module-loader/requirejs-config.js')}}" src="{{URL::to('assets/requirejs/require.js')}}"></script>
<script type="text/javascript" src="{{URL::to('js/login/login.js')}}"></script>

</body>
</html>
