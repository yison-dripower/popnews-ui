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
<ul>
  @foreach ($renders as $news)
<dl>
  <dt>{{$news->title}}</dt>
  <dd class="digest">{{$news->digest}}</dd>
  <dd class="link"><a href="{{$news->link}}">阅读原文</a></dd>
</dl>
  @endforeach
</ul>
</html>
