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
  <div class="filters">
    消息源订阅
  </div>
  <ul class="list-group no-hover">
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="text" placeholder="最多6个汉字或12个英文" />
        </div>
      </div>
      <i>名称：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="text" placeholder="通常是消息列表网页链接" />
        </div>
      </div>
      <i>URL：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="checkbox" /> 特别关注
          <input type="checkbox" /> 推送
        </div>
      </div>
      <i>权重：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="radio" name="frequency" /> 10分钟
          <input type="radio" name="frequency" /> 30分钟
          <input type="radio" name="frequency" checked="checked" /> 1小时
          <input type="radio" name="frequency" /> 3小时
          <input type="radio" name="frequency" /> 6小时
          <input type="radio" name="frequency" /> 12小时
          <input type="radio" name="frequency" /> 1天
        </div>
      </div>
      <i>频率：</i>
    </li>
    <li class="fn-clear">选择模式 <a style="margin-left:20px;">新增模式</a></li>
    <div class="mode-select">
      <li>
        <select name="">
          <option>公众号</option>
        </select>
      </li>
    </div>
    <div class="custom hidden">
      <li><i>新闻：</i><input type="text" placeholder="如：.item" /></li>
      <li><i>标题：</i><input type="text" placeholder="如：.title" /></li>
      <li><i>链接：</i><input type="text" placeholder="如：.link（选填）" /></li>
      <li><i>描述：</i><input type="text" placeholder="如：.digest（选填）" /></li>
    </div>
  </ul>
  <div class="action">
    <a>测试</a>
  </div>
  <div class="action">
    <a>保存</a>
  </div>
</div>
<script src="http://cdn.staticfile.org/jquery/1.7.1/jquery.min.js"></script>
<script>
</script>
</html>
