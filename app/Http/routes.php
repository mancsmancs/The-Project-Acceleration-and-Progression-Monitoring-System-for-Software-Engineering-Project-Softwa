<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
Route::group(['prefix' => 'auth'], function() {

    Route::get('register', ['as' => 'register', 'uses' => 'UserController@register']);
    Route::post('register', ['as' => 'register', 'uses' => 'UserController@register']);
    Route::get('/activate', ['as' => 'activate', 'uses' => 'UserController@activate']);
    Route::get('/login', ['as' => 'login', 'uses' => 'UserController@login']);
    Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
    Route::get('/home', ['as' => 'home', 'uses' => 'UserController@home']);
});


Route::get('test', function() {
  return 'rrrrrr';
    //Auth::logout();
});



Route::group(['prefix' => 'user'], function() {
     Route::any('/profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
   //Route::any('/profile_delete', ['as' => 'profile', 'uses' => 'UserController@delete']);
  
});
 
Route::controller('project','ProjectController');
Route::controller('activity','ActivityController');
Route::controller('appointment','AppointmentController');
Route::controller('notification','NotificationController');
Route::controller('task','TaskController');
///Route::controller('home','HomeController');

Route::get('/test_delete','UserController@deleteUser');

 Route::get('/', ['as' => 'dashboard', 'uses' => 'UserController@dashboard']);
 

 //Route::get('/home', ['as'  =>'home','user' =>'UserController@home']);
 
 //Route::get('home', 'UserController@home');
//Route::get('home','HomeController@index');

Route::get('/route_list',function(){
   $routeCollection = Route::getRoutes();

foreach ($routeCollection as $value) {
    echo $value->getPath().'<br>';
} 
});
