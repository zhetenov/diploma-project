<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

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

Auth::routes();
Route::get('/admin/{vue}', function () {
    if (auth()->check()) {
        return view('admin');
    }
    return redirect('/login');
})->where("vue", "[\/\w\.-]*");

Route::get('/', 'IndexController@index');


Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix'=>'api'], function(){
    Route::get('/users', 'Api\DataController@getUsers');
    Route::post('mailing/send', 'Api\EmailController@sendEmail');
    Route::post('/upload/data', 'Api\DataController@uploadData');
    Route::get('/statistics', 'Api\StatisticController@getStatistics');
});
