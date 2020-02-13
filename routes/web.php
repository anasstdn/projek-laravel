<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// // route to show the login form
// Route::get('/login', array('uses' => 'HomeController@showLogin'));

// // route to process the form
// Route::post('/login', array('uses' => 'HomeController@doLogin'));

// Route::get('/logout', array('uses' => 'HomeController@doLogout'));

Route::get('/user/verify/{token}','Auth\RegisterController@verifyUser');

Route::get('/send', 'SendMessageController@index')->name('send');
Route::post('/postMessage', 'SendMessageController@sendMessage')->name('postMessage');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    // return view('welcome');
    if (Auth::check()) {
        return redirect('home');
    } else {
        return redirect('login');
    }
});

Auth::routes();

Route::group( ['prefix'=>'home','middleware' => ['role:superadministrator|administrator|manager']], function() {
	Route::get('/', 'HomeController@index');
	Route::get('/load-data','HomeController@loadData');
	Route::get('/get-chart','HomeController@getChart');
	Route::get('/get-notif', 'HomeController@getNotif');
	Route::resource('home', 'HomeController');
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/data', 'DataController@index');
Route::get('downloadData/{type}', 'DataController@downloadData');
Route::post('data-importData', 'DataController@importData');
Route::resource('data', 'DataController');

Route::get('peramalan/forecast', 'PeramalanController@forecasting');
Route::resource('peramalan', 'PeramalanController');



Route::get('user/load-data','UserController@loadData');
Route::get('user/json','UserController@json');
Route::get('user/activate/{id}','UserController@activate');
Route::get('user/update/{id}','UserController@update');
Route::get('user/deactivate/{id}','UserController@deactivate');
Route::get('user/{id}/reset','UserController@reset');
Route::get('user/{id}/destroy','UserController@destroy');
Route::match(['get','post'],'user/cek-username','UserController@cekUsername');
Route::match(['get','post'],'user/cek-email','UserController@cekEmail');
Route::match(['get','post'],'user/send-data','UserController@sendData');
Route::match(['get','post'],'user/delete','UserController@delete');
Route::resource('user','UserController');
Route::delete('user/{id}/restore','UserController@restore');


Route::get('permission/load-data','PermissionController@loadData');
Route::resource('permission','PermissionController');
Route::delete('permission/{id}/restore','PermissionController@restore');

Route::post('role/createpermissionrole', ['as' => 'role.createpermissionrole', 'uses' => 'RoleController@createpermissionrole']);

Route::get('role/load-data', 'RoleController@loadData');
Route::get('permission-role/get/{id}/menu', 'RoleController@hakmenus');
Route::get('role/permission-role/get/{id}/menu', 'RoleController@hakmenus');
Route::resource('role', 'RoleController');
Route::delete('role/{id}/restore', 'RoleController@restore');

