<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
  if(\App\Model\User::check() == false){
    header('Location:login');
  } else {
    header('Location:home');
  }
  exit;
});

Route::get('login', function () {
  if(\App\Model\User::check()){
    header('Location:home');
    exit;
  }
  /*App\User::create(array(
      'name' => 'Popea',
      'password' => Hash::make('Apparently')
  ));*/
  return view('login');
});

Route::post('login-act', [
  'as' => 'login-act', 'uses' => 'NewsController@loginAct'
]);

Route::get('home', [
  'as' => 'home', 'uses' => 'NewsController@showList'
]);

Route::get('subscribe/list', [
  'as' => 'subscribe', 'uses' => 'NewsController@subscribeList'
]);

Route::get('subscribe/add', [
  'as' => 'subscribe-add', 'uses' => 'NewsController@subscribeAdd'
]);

Route::get('subscribe/test', [
  'as' => 'subscribe-test', 'uses' => 'NewsController@subscribeTest'
]);
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
