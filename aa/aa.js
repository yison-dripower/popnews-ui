var arguments = process.argv;
var url = arguments[2];
var news = arguments[3];
var title = arguments[4];
var link = arguments[5];
var phantom    = require("phantom");
var sleep = require("sleep");

phantom.create(function (ph) {
  ph.createPage(function (page) {
    page.open(url, function (status) {
      var rule = {
        news: news,
        title: title,
        link: link
      }
      sleep.sleep(3);
      page.evaluate(function (rule) {
        var newsList = document.querySelectorAll(rule.news);
        var list = [];
        if(newsList.length < 1) {
          return false;
        }
        for(i=0; i < newsList.length; i++) {
          var item = newsList[i];
          if(typeof item == 'object') {
            var title = item.querySelector(rule.title);
            var link = item.querySelector(rule.link);
            var news = {};
            news['title'] = title.innerText;
            if(link != undefined && link != null) {
              news['link'] = link.href ;
            }
          }
          list.push(news);
        }
        return list ;
      }, function (result) {
        if(result === false  || result == null || result.length < 1) {
          console.log('没有找到新闻');
        } else if(result[0]['title'] == undefined) {
          console.log('没有找到标题');
        } else if(result[0]['link'] == undefined) {
          console.log('没有找到新闻链接');
        }else {
          console.log('测试成功！');
        }
        ph.exit();
      }, rule);
    });
  });
});
