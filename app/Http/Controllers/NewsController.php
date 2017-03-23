<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class NewsController extends Controller {

  const SITE_36KR = '36kr';
  const TWITTER = 'twitter';
  const PODCAST = 'podcast';
  const TWITTER_DOMAIN = 'https://twitter.com';

  function showList()
   {
      $this->beforeLogin();
      $today = date('Y-m-d');
      $yesterday = date('Y-m-d', strtotime('-1 day'));
      $user = $_SESSION['user']['name'];
      if (!empty($_REQUEST) && !empty($_REQUEST['cat'])) {
        $cat = $_REQUEST['cat'];
      } else {
        $cat = 'all';
      }

      $sbsNotInIds = [];
      $sbsInIds = [];
      if ($cat === 'less') {
        $sbs = \App\Model\Source::where('frequency', '<', 360)->get();
        foreach($sbs as $v) {
          $sbsNotInIds[] = $v->id;
        }
      }
      if ($cat === 'informed') {
        $sbs = \App\Model\Source::where('frequency', '>=', 360)->get();
        foreach($sbs as $v) {
          $sbsNotInIds[] = $v->id;
        }
      }
      if ($cat === 'podcast') {
        $sbs = \App\Model\Source::whereRule(46)->get();
        foreach($sbs as $v) {
          $sbsInIds[] = $v->id;
        }
      }

      $query = \App\Model\Subscribe::whereUser($user)->whereStatus(0);
      if ($cat === 'podcast') {
        $subscribes = $query->whereIn('source', $sbsInIds)->get();
      } else {
        $subscribes = $query->whereNotIn('source', $sbsNotInIds)->get();
      }

      $subscribeIds = [];
      foreach($subscribes as $v) {
        $subscribeIds[] = $v->source;
      }

      if ($cat !== 'podcast') {
        $newsListOfToday = \App\Model\News::where('gmt_create','>',$today)
          ->whereIn('source', $subscribeIds)->orderBy('id','desc')->get();
        foreach($newsListOfToday as &$v) {
          $v->source = \App\Model\Source::whereId($v->source)->first();
        }
        $newsListOfYesterday = \App\Model\News::where('gmt_create','>',$yesterday)
          ->whereIn('source', $subscribeIds)->where('gmt_create','<',$today)->orderBy('id','desc')->get();
        foreach($newsListOfYesterday as &$v) {
          $v->source = \App\Model\Source::whereId($v->source)->first();
        }
        $podcastList = [];
      } else {
        $newsListOfYesterday = [];
        $newsListOfToday = \App\Model\News::whereIn('source', $subscribeIds)->orderBy('id','desc')->take(20)->get();
        foreach($newsListOfToday as &$v) {
          $v->source = \App\Model\Source::whereId($v->source)->first();
        }
      }

      return view('home/index', [
        'newsListOfToday'=> $newsListOfToday,
        'newsListOfYesterday'=> $newsListOfYesterday,
        'today'=> date('m-d'),
        'yesterday'=> date('m-d', strtotime('-1 day')),
        'cat' => $cat
      ]);
   }

   function loginAct(Request $request) {
     $name = $_POST['nick'];
     $password = $_POST['password'];
     if (\App\Model\User::validate($name, $password)){
       $user = \App\Model\User::getByName($name);
       $_SESSION['user'] = $user->toArray();
       echo 'success';
     } else {
       echo 'failure';
     }
   }

   function subscribeList() {
     $this->beforeLogin();
     $subscribes = \App\Model\Subscribe::whereUser($_SESSION['user']['name'])
       ->whereStatus(0)->get();
     $sourceIds = [];
     foreach($subscribes as $v) {
       $sourceIds[] = $v->source ;
     }
     $sourceList = \App\Model\Source::orderBy('id','desc')->get();
     return view('subscribe/list',[
       'sourceList' => $sourceList,
       'sourceIds' => $sourceIds
     ]);
   }

   function subscribeAdd() {
     $ruleList = \App\Model\Rule::orderBy('id','asc')->get();
     return view('subscribe/add',[
       'ruleList' => $ruleList
     ]);
   }

   function subscribeAct() {
     $id = $_POST['id'];
     $status = $_POST['on'] == 1 ? 0 : -1;
     $user = $_SESSION['user']['name'];
     if(empty($user)) {
       echo "failure";
       exit;
     }
     $subscribe = \App\Model\Subscribe::whereSource($id)
        ->whereUser($user)->first();
     if(empty($subscribe)) {
       $subscribe = new \App\Model\Subscribe;
     }
     $subscribe->user = $user;
     $subscribe->source = $id;
     $subscribe->status = $status;
     if($subscribe->save()) {
       echo 'success';
     } else {
       echo 'failure';
     }
   }

   function subscribeAddAct() {
     $data = $_POST;
     $template = json_decode($data['template'], true);
     if($data['mode'] == 'add') {
       $rule = new \App\Model\Rule();
       $rule->name = $template['name'];
       $rule->news = $template['news'];
       $rule->title = $template['title'];
       $rule->link = $template['link'];
       $rule->author = $_SESSION['user']['name'];
       if($template['digest']!='') {
         $rule->digest = $template['digest'];
       }
       $rule->save();
       $ruleId = $rule->id;
     } else {
       $ruleId = $template['id'];
     }
     $source = new \App\Model\Source();
     $source->name = $data['name'];
     if($data['description'] != '') {
       $source->description = $data['description'];
     }
     $source->url = $data['url'];
     $source->special_type = $data['specialType'];
     $source->frequency = $data['frequency'];
     $source->rule = $ruleId;
     $source->avatar = $data['avatar'];
     $source->author = $_SESSION['user']['name'];
     if($source->save()) {
       echo 'success';
     } else {
       echo 'failure';
     }
   }

   function subscribeTest() {
     set_time_limit(0);
     $url = $_POST['url'];
     $news = $_POST['news'];
     $title = $_POST['title'];
     $link = $_POST['link'];
     $output = shell_exec("node ~/aa/aa.js '".$url."' '".$news."' '".$title."' '".$link."'");
     print_r($output);
   }

   function log() {
     set_time_limit(0);
     if(isset($_GET['f']) && $_GET['f'] == 'err') {
       $output = shell_exec("cat /var/www/html/popnews-ui/aa/err.log");
     } else {
       $output = shell_exec("cat /var/www/html/popnews-ui/aa/out.log");
     }
     echo "<pre>$output</pre>";
   }

   function specialSite() {
     set_time_limit(0);
     $mode = $_GET['site'];
     switch($mode) {
       case self::SITE_36KR :
         $data = $this->get36krDate();
         break ;
       case self::PODCAST :
         $data = $this->getPodCast();
         break ;
       case self::TWITTER :
         $selectors = [
           'url'=> self::TWITTER_DOMAIN.$_GET['suffix'],
           'title'=> '.stream-item',
           'link' => '.tweet-timestamp'
         ];
         $data = $this->getWithPHPQuery($selectors);
         break ;
       default:;
     }
     return view('home/special', [
       'renders'=> $data
     ]);
   }

   function scalaNews() {
     $list = \App\Model\News::where('special_type', 1)
        ->where('status', 0)
        ->orderBy('id','desc')
        ->take(300)
        ->get();
     echo json_encode([
      'results' => $list
     ]);
   }


   private function beforeLogin() {
     if(\App\Model\User::check() == false){
       header('Location:login');
       exit;
     }
   }

   private function get36krDate() {
     $url = "http://36kr.com/newsflashes.json";
     $data = file_get_contents($url);
     $r = json_decode($data, true);
     $renders = [];
     foreach($r['props']['newsflashList|newsflash'] as $v) {
       $item['title'] = $v['title'];
       $item['digest'] = $v['description'];
       $item['link'] = $v['news_url'];
       $renders[] = $item;
     }
     return $renders;
   }

   private function getPodCast() {
     $source = $_GET['source'];
     $rss = simplexml_load_file(urldecode($source));
     $renders = [];
     foreach($rss->channel->item as $item) {
       $i['title'] = $item->title;
       $i['digest'] = $item->description;
       $i['link'] = $item->enclosure['url'];
       $renders[] = $i;
     }
     return $renders;
   }

   private function getWithPHPQuery($selectors) {
     $content = file_get_contents('http://baidu.com');
     $doc = phpQuery::newDocumentHTML($content);
     exit;
     phpQuery::selectDocument($doc);
     $renders = [];
     $items = pq($selectors['item']);
     $items->each(function($t) {
       if($selectors['link'] == '.') {
         $item['title'] = pq($t)->text();
       } else {
         $item['title'] = pq($t)->find($selectors['title'])->text();
       }
       if($selectors['link'] == '.') {
         $item['link'] = pg($t)->getAttribute('href');
       } else {
         $item['link'] = pg($t)->find($selectors['link'])->getAttribute('href');
       }
       $item['digest'] = pg($t)->find($selectors['description'])->text();
       $renders[] = $item;
     });
     return $renders ;
   }
}
