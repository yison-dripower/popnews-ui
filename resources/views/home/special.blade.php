<!doctype html>
<html>
<head>
<title>想看的都在这</title>
<meta charset="utf8" />
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
