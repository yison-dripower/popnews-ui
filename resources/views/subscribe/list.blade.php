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
<div id="news-list" class="subscribe">
  <div class="filters">
    <a class="selected">所有</a>
    <a>已订阅</a>
  </div>
  <div class="list-hd fn-clear">
    消息源订阅
    <a href="/subscribe/add" class="fn-right add-news-source">+ 提交源</a>
  </div>
  <ul class="list-group">
      @foreach ($sourceList as $source)
    <dl class="list-group-item fn-clear title">
      <div class="info fn-left">
        <div class="info-wrap">
          <dt>{{$source->name}}</dt>
          <dd>{{$source->description}} <em>{{$source->author}}</em></dd>
          <div class="fn-right">
            <span class="switch"></span>
          </div>
        </div>
      </div>
      <div  class="avatar fn-left">
        <img src="{{$source->avatar}}" width="30" height="30" />
      </div>
    </dl>
      @endforeach
  </ul>
</div>
<script src="http://cdn.staticfile.org/jquery/1.7.1/jquery.min.js"></script>
<script>
$(document).on('click', '#news-list li', function(){
  if($(this).hasClass('focus')) {
    $(this).removeClass('focus');
  } else {
    $('#news-list li').removeClass('focus');
    if($(this).find('.digest').length > 0) {
      $(this).addClass('focus');
    }
  }
});
$(document).on('click', '#news-list li a', function(event){
  event.stopPropagation();
});
</script>
</html>
