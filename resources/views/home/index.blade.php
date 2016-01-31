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
<div id="news-list">
  <div class="filters tabs fn-clear">
    <a class="selected">所有</a>
    <a>特别关注</a>
    <a>收藏</a>
    <a class="fn-right plus" href="/subscribe/list">+</a>
  </div>
  <div class="list-hd">
    今日 {{$today}}
  </div>
  <ul class="list-group">
      @foreach ($newsListOfToday as $news)
    <li class="list-group-item title fn-clear">
      <div class="fn-left news-box">
        <div class="news-box-wrap">
          <a @if($news->link)href="{{$news->link}}"@endif>{{$news->title}}</a>
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
  <div class="list-hd yesterday">
    昨日 {{$yesterday}}
  </div>
  <ul class="list-group">
      @foreach ($newsListOfYesterday as $news)
    <li class="list-group-item title fn-clear">
      <div class="fn-left news-box">
        <div class="news-box-wrap">
          <a @if($news->link)href="{{$news->link}}"@endif>{{$news->title}}</a>
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
</script>
</html>
