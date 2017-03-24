require('phantomjs-polyfill')

var arguments = process.argv;
var url = arguments[2];
var news = arguments[3];
var title = arguments[4];
var link = arguments[5];
var phantom    = require("phantom");
var sleep = require("sleep");

console.log('url:' + url)
console.log('news:' + news)
console.log('title:' + title)
console.log('link:' + link)

var USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36';

phantom.create(['--ignore-ssl-errors=yes', '--load-images=no'])
  .then(instance => {
    phInstance = instance
    return instance.createPage()
  })
  .then(page => {
    page.setting('userAgent', USER_AGENT)
    page.open(url).then(function (status) {
      var rule = {
        news: news,
        title: title,
        link: link
      }
      sleep.sleep(3)
      page.evaluate(function (rule) {
        var newsList = document.querySelectorAll(rule.news);
        var list = [];
        if(newsList.length < 1) {
          return false;
        }
        for(i=0; i < newsList.length; i++) {
          var item = newsList[i];
          if(typeof item == 'object') {
            var title = rule.title == '.' ? item : item.querySelector(rule.title);
            var link = rule.link == '.' ? item : item.querySelector(rule.link);
            var news = {};
            news['title'] = title.innerText;
            if(link != undefined && link != null) {
              news['link'] = link.href ;
            }
          }
          list.push(news);
        }
        return list ;
      }, rule).then(function(result){
        if(result === false  || result == null || result.length < 1) {
          console.log('没有找到新闻');
        } else if(result[0]['title'] == undefined) {
          console.log('没有找到标题');
        }else {
          console.log('测试成功！');
        }
        phInstance.exit()
      });
    })
  })
  .catch(error => {
    console.log(error)
    phInstance.exit()
  });
