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
     $output = shell_exec('ls -lart');
     return view('subscribe/add');
   }

   function subscribeTest() {
     $output = shell_exec('node ~/Dev/test/aa.js');
     print_r($output);
   }

   private function beforeLogin() {
     if(\App\Model\User::check() == false){
       header('Location:login');
       exit;
     }
   }
}
