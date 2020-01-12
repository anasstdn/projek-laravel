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

Route::get('/', function () {
    // return view('welcome');
    if (Auth::check()) {
        return redirect('home');
    } else {
        return redirect('login');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('home/load-data','HomeController@loadData');
Route::resource('home', 'HomeController');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/data', 'DataController@index');
Route::get('downloadData/{type}', 'DataController@downloadData');
Route::post('data-importData', 'DataController@importData');
Route::resource('data', 'DataController');



Route::get('user/load-data','UserController@loadData');
Route::resource('user', 'UserController');

Route::get('permission/load-data','PermissionController@loadData');
Route::resource('permission', 'PermissionController');

