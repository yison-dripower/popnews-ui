<!doctype html>
<html>
<head>
<title>Pop News - 想看的都在这</title>
<meta charset="utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<link href="{{ URL::asset('css/base.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="header">
  <h1><a href='/'>Pop News</a></h1>
</div>
<div id="news-list">
  <div class="filters tabs fn-clear">
    <a class="selected">所有</a>
    <a>科技</a>
    <a>电影</a>
    <a>经济</a>
    <a class="fn-right" href="/subscribe/list">+</a>
  </div>
  <div class="list-hd">
    今日 01-18
  </div>
  <ul class="list-group">
      @foreach ($newsList as $news)
    <li class="list-group-item title fn-clear">
      <div class="fn-left news-box">
        <div class="news-box-wrap">
          <a href="{{$news->link}}" target="_blank">{{$news->title}}</a>
          <span class="date">{{$news->gmt_create}}</span>
        </div>
      </div>
      <div class="fn-left avatar-box">
        <img src="{{$news->source->avatar}}" class="avatar" width="30" height="30" />
      </div>
        @if($news->digest)
      <div class="digest">
        {{$news->digest}}
      </div>
        @endif
    </li>
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
setInterval(function(){
  window.location.reload();
},60000);
</script>
</html>
