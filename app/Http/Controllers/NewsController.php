<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class NewsController extends Controller {

  const SITE_36KR = "36kr";

  function showList()
   {
      $this->beforeLogin();
      $today = date('Y-m-d');
      $yesterday = date('Y-m-d', strtotime('-1 day'));
      $user = $_SESSION['user']['name'];
      $subscribes = \App\Model\Subscribe::whereUser($user)
        ->whereStatus(0)->get();

      $subscribeIds = [];
      foreach($subscribes as $v) {
        $subscribeIds[] = $v->source;
      }

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
      return view('home/index', [
        'newsListOfToday'=> $newsListOfToday,
        'newsListOfYesterday'=> $newsListOfYesterday,
        'today'=> date('m-d'),
        'yesterday'=> date('m-d', strtotime('-1 day'))
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
       case self::SITE_36KR => {
         $data = $this->get36krDate();
       }
       default:;
     }
     return view('home/special', [
       'renders'=> $renders
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
     foreach($r as $v) {
       $item['title'] = $v['hash_title'];
       $item['digest'] = $v['description_text'];
       $item['link'] = $v['news_url'];
       $renders[] = $item;
     }
     return $renders;
   }
}
