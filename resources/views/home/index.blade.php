<!doctype html>
<html>
<head>
<title>Pop News - 想看的都在这</title>
<meta charset="utf8" />
<link href="{{ URL::asset('css/base.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="header">
  <h1><a href='/'>Pop News</a></h1>
</div>
<div id="news-list">
  <div class="filters fn-clear">
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
    <li class="list-group-item title">
      <img src="{{$news->source->avatar}}" class="avatar" width="30" height="30" />
      <a href="{{$news->link}}" target="_blank">{{$news->title}}</a>
      <span class="date">{{$news->gmt_create}}</span>
        @if($news->digest)
      <div class="digest">
        {{$news->digest}}
      </div>
        @endif
    </li>
      @endforeach
  </ul>
</div>
</html>
