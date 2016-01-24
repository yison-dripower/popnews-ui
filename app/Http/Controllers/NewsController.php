<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class NewsController extends Controller {

  function showList()
   {
      $this->beforeLogin();
      $newsList = \App\Model\News::orderBy('id','desc')->get();
      foreach($newsList as &$v) {
        $v->source = \App\Model\Source::whereId($v->source)->first();
      }
      return view('home/index', [
        'newsList'=> $newsList
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
     $sourceList = \App\Model\Source::orderBy('id','desc')->get();
     return view('subscribe/list',[
       'sourceList' => $sourceList
     ]);
   }

   function subscribeAdd() {
     $ruleList = \App\Model\Rule::orderBy('id','desc')->get();
     return view('subscribe/add',[
       'ruleList' => $ruleList
     ]);
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
     $output = shell_exec("cd /root/project/phantom/;node aa.js '".$url."' '".$news."' '".$title."' '".$link."'");
     print_r($output);
   }

   private function beforeLogin() {
     if(\App\Model\User::check() == false){
       header('Location:login');
       exit;
     }
   }
}
