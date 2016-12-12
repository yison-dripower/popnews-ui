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
          <input type="text" name="subject" placeholder="最多6个汉字或12个英文" />
        </div>
      </div>
      <i>名称：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="text" name="description" placeholder="写点介绍呗~" />
        </div>
      </div>
      <i>简介：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="text" name="avatar" placeholder="可能有防盗链，建议先下载头像，然后发布微博获取图片链接" />
        </div>
      </div>
      <i>头像：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="text" name="url" placeholder="通常是消息列表网页链接" />
        </div>
      </div>
      <i>URL：</i>
    </li>
    <li class="fn-clear">
      <div class="fn-left group-field">
        <div class="field-wrap">
          <input type="radio" name="frequency" value="10" /> 10分钟
          <input type="radio" name="frequency" value="30" /> 30分钟
          <input type="radio" name="frequency" value="60" /> 1小时
          <input type="radio" name="frequency" value="180" /> 3小时
          <input type="radio" name="frequency" value="360" checked="checked" /> 6小时
          <input type="radio" name="frequency" value="720" /> 12小时
          <input type="radio" name="frequency" value="1440" /> 1天
        </div>
      </div>
      <i>频率：</i>
    </li>
    <li class="fn-clear mode">
      <a class="selected">选择模式</a>
      <a class="add" style="margin-left:20px;">新增模式</a>
    </li>
    <div class="mode-select">
      <li>
        <select name="">
            @foreach ($ruleList as $rule)
          <option value="{{$rule->toJson()}}" @if ($rule->id == 7) selected @endif>{{$rule->name}}</option>
            @endforeach
        </select>
      </li>
    </div>
    <div class="custom hidden">
      <li class="fn-clear">
        <div class="fn-left group-field">
          <div class="field-wrap">
            <input type="text" name="rule_name" placeholder="请填写抓取模式名称" />
          </div>
        </div>
        <i>模式：</i>
      </li>
      <li class="fn-clear">
        <div class="fn-left group-field">
          <div class="field-wrap">
            <input type="text" name="rule_news" placeholder="如：.item" />
          </div>
        </div>
        <i>新闻：</i>
      </li>
      <li class="fn-clear">
        <div class="fn-left group-field">
          <div class="field-wrap">
            <input type="text" name="rule_title" placeholder="如：.title" />
          </div>
        </div>
        <i>标题：</i>
      </li>
      <li class="fn-clear">
        <div class="fn-left group-field">
          <div class="field-wrap">
            <input type="text" name="rule_link" placeholder="如：.link" />
          </div>
        </div>
        <i>链接：</i>
      </li>
      <li class="fn-clear">
        <div class="fn-left group-field">
          <div class="field-wrap">
            <input type="text" name="rule_digest" placeholder="如：.digest（选填）" />
          </div>
        </div>
        <i>描述：</i>
      </li>
    </div>
  </ul>
  <div class="action">
    <a class="test-trigger">测试</a>
  </div>
  <div class="action add-action hidden">
    <a class="save-trigger">保存</a>
  </div>
</div>
<script src="http://cdn.staticfile.org/jquery/1.7.1/jquery.min.js"></script>
<script>
var testToken = true;
$('.test-trigger').click(function(){
  var params = formatParams();
  var url = params.url;
  var template = params.template;
  var news = template.news;
  var title = template.title;
  var link = template.link;
  var _this = $(this);
  if(url == '') {
    alert('请填写URL！');
  } else if(news == '') {
    alert('请填写新闻代码！');
  } else if(title == '') {
    alert('请填写标题代码！');
  } else if(news == '') {
    alert('请填写链接代码！');
  } else {
    var params = {
      url: url,
      news: news,
      title: title,
      link: link
    };
    if(!testToken) {
      return ;
    }
    testToken = false;
    _this.text('正在测试…');
    $.post('/subscribe/test', params,
      function(data) {
        alert(data);
        if(data.indexOf('测试成功！') != -1) {
          $('.add-action').removeClass('hidden');
        } else {
          $('.add-action').addClass('hidden');
        }
      }
    ).done(function(){
      testToken = true;
      _this.text('测试');
    });
  }
});
var saveToken = true;
$('.save-trigger').click(function(){
  var params = formatParams();
  if(params.name == '') {
    alert('请填写消息源名称！');
  } else if(params.url == '') {
    alert('请填写URL！');
  } else if(params.avatar == '') {
    alert('请填写头像！');
  }
  if(params.mode == 'add') {
    if(params.name == '' ||
       params.news == '' ||
       params.title == '' ||
       params.link == '') {

      alert('请填写完整的模式信息');
    }
  }
  if(!saveToken) {
    return ;
  }
  saveToken = false;
  params.template = JSON.stringify(params.template);
  $.post('/subscribe/addAct', params,
    function(data) {
      if(data == 'success') {
        window.location.href = '/subscribe/list';
      } else {
        alert('添加失败，请重试！');
      }
    }
  ).done(function(){
    saveToken = false;
  });
});
var formatParams = function() {
  var form = $('#news-list');
  var description = $.trim(form.find('[name=description]').val());
  var avatar = $.trim(form.find('[name=avatar]').val());
  var name = $.trim(form.find('[name=subject]').val());
  var url = $.trim(form.find('[name=url]').val());
  var frequency = form.find('[name=frequency]:checked').val();
  var mode = $('.mode-select').is(':visible') ? 'select' : 'add';
  return {
    name: name,
    description: description,
    avatar: avatar,
    url: url,
    frequency: frequency,
    mode: mode,
    template: formatTemplate(mode)
  };
}
var formatTemplate = function(mode) {
  if(mode == 'select') {
    return $.parseJSON($('.mode-select select').val());
  } else {
    return {
      name: $.trim($('[name=rule_name]').val()),
      news: $.trim($('[name=rule_news]').val()),
      title: $.trim($('[name=rule_title]').val()),
      link: $.trim($('[name=rule_link]').val()),
      digest: $.trim($('[name=rule_digest]').val())
    };
  }
};
$('.mode a').click(function(){
  $(this).addClass('selected').siblings('a').removeClass('selected');
  if(! $(this).hasClass('add')) {
    $('.mode-select').removeClass('hidden');
    $('.custom').addClass('hidden');
  } else {
    $('.mode-select').addClass('hidden');
    $('.custom').removeClass('hidden');
  }
  $('.add-action').addClass('hidden');
});
$('[name=url]').change(function(){
  $('.add-action').addClass('hidden');
});
$('.mode-select').change(function(){
  $('.add-action').addClass('hidden');
});
</script>
</html>
