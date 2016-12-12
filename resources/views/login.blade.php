<!doctype html>
<html>
<head>
<title>想看的都在这</title>
<meta charset="utf8" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::asset('icon/apple-touch-icon-144x144.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ URL::asset('icon/apple-touch-icon-120x120.png') }}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::asset('icon/apple-touch-icon-72x72.png') }}">
<link rel="apple-touch-icon-precomposed" href="{{ URL::asset('icon/apple-touch-icon-57x57.png') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<link href="{{ URL::asset('css/base.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="header">
  <h1><a href='/'>Pop News</a></h1>
</div>
<div id="news-list" class="login">
  <ul class="list-group no-hover">
    <li class="fn-clear">
      <div class="nick fn-left">
        <div class="nick-wrap">
          <input type="text" name="nick" />
        </div>
      </div>
      <i class="fn-left">昵称：</i>
    </li>
    <li class="fn-clear">
      <div class="nick fn-left">
        <div class="nick-wrap">
          <input type="password" name="password"  />
        </div>
      </div>
      <i class="fn-left">密码：</i>
    </li>
  </ul>
  <div class="action">
    <a>登录</a>
  </div>
</div>
<script src="http://cdn.staticfile.org/jquery/1.7.1/jquery.min.js"></script>
<script>
$('.action a').click(function(){
  var form = $('#news-list');
  var nick = $.trim(form.find('[name=nick]').val());
  var password = $.trim(form.find('[name=password]').val());
  if(nick == '' || password == '') {
    alert('请输入完整的登录信息');
  } else {
    $.post('/login-act', {
      nick: nick,
      password: password
    }, function(data){
      if(data == 'success') {
        window.location.reload();
      } else {
        alert('用户名或密码错误，请重试');
      }
    });
  }
});
</script>
</html>
