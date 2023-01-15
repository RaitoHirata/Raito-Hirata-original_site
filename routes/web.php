<?php

use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', function () {
    return view('index') ;
})->name('index');


Route::get('/login','Contactcontroller@login')->name('login');
Route::group(['middleware'=>['auth','can:user-higher']],function(){
    Route::post('/login','Contactcontroller@loginComplete')->name('login.home');
    Route::get('/register','Contactcontroller@register')->name('register');
    Route::get('/login/search','Contactcontroller@userHome')->name('user_home');
    Route::get('/score','Contactcontroller@scorelink')->name('scorelink');
    Route::get('/login/score','Contactcontroller@loginScorelink')->name('login_scorelink');
    Route::get('/login/search','Contactcontroller@loginSearch')->name('login_search');
    Route::get('/login/scoreedit','Contactcontroller@userScoreeditview')->name('user_score_edit_view');
    Route::post('/login/scoreedit','Contactcontroller@userScoreedit')->name('user_score_edit');
    Route::get('/logout','Contactcontroller@logout')->name('logout');
    Route::post('/login/search','Contactcontroller@loginSearch')->name('login_search');
    Route::post('/register/complete','Contactcontroller@checkregister')->name('checkregister');
    Route::post('/','Contactcontroller@search')->name('search');
});

Route::group(['middleware'=>['auth','can:admin-higher']],function(){
    //manager
    Route::get('/mng_register','Contactcontroller@mngregister')->name('mngregister');
    //Route::get('/manager_login','Contactcontroller@managerLogin')->name('manager_login');
    Route::get('/manager_home','Contactcontroller@managerHome')->name('mnglogin_home');
    Route::post('/manager_home','Contactcontroller@mngloginComplete')->name('mnglogin_home');
    Route::get('/manager_home/scoredata','Contactcontroller@scoreData')->name('scoredata');
    Route::get('/manager_home/scoredata_delete','Contactcontroller@delete')->name('scoredelete');
    Route::get('/manager_home/scoredata/scoredata_release','Contactcontroller@release')->name('release');
    Route::get('/manager_home/scoredata/scoredata_norelease','Contactcontroller@norelease')->name('norelease');
    Route::get('/manager_home/scoredata/scoredata_register','Contactcontroller@scoredataRegister')->name('scoredata_register');
    Route::post('/manager_home/scoredata/scoredata_register','Contactcontroller@uplode')->name('uplode');
    Route::get('/manager_home/scoredata/scoredata_detail','Contactcontroller@scoreDetail')->name('scoreDetail');
    Route::get('/manager_home/scoredata/scoredata_edit','Contactcontroller@scoreedit')->name('scoreedit');
    Route::post('/manager_home/scoredata/scoredata_edit','Contactcontroller@update')->name('update');
});
//Route::post('/ajaxrelease','Contactcontroller@ajaxrelease')->name('posts.ajaxrelease');
//Route::post('/ajaxnorelease','Contactcontroller@ajaxnorelease')->name('posts.ajaxnorelease');

//マイリスト
Route::post('ajaxlike', 'Contactcontroller@ajaxlike')->name('posts.ajaxlike');

//パスワードリセット
Route::get('/password', 'Contactcontroller@userPw')->name('user_pw');
Route::post('/password/reset', 'Contactcontroller@pwresetMail')->name('user_pw_urlmail');
Route::get('/password/reset/newpassword', 'Contactcontroller@newpassword')->name('user_newpassword');
Route::post('/password/reset/newpassword', 'Contactcontroller@update_password')->name('update_password');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
