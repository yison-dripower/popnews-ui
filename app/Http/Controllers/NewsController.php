<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class NewsController extends Controller {
  function showList()
   {
      $newsList = \App\Model\News::get();
      foreach($newsList as &$v) {
        $v->source = \App\Model\Source::whereId($v->source)->first();
      }
      return view('home/index', [
        'newsList'=> $newsList
      ]);
   }
}
