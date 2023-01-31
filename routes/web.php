<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Twittercontroller;
use Illuminate\Support\Facades\Route;
use App\Providers\AppServiceProvider;
use App\Models\score;
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
    $scorerank = score::select
    ('artist_name as artist_name' , 'song_name as song_name' ,'access_count')
    ->ORDERBY('access_count','DESC')->take(3)->get();
    return view('index',['scorerank' => $scorerank ]) ;
})->name('index');


Route::post('/', [Contactcontroller::class, 'search'])->name('search');
Route::get('/score',[ContactController::class, 'scorelink'])->name('scorelink');

Route::group(['middleware'=>['auth','can:admin-higher']],function(){
    //manager
    Route::get('/mng_register',[Contactcontroller::class, 'mngregister'])->name('mngregister');
   // Route::get('/manager_login',[Contactcontroller::class,'managerLogin'])->name('manager_login');
   // Route::get('/manager_home','[Contactcontroller::class,'managerHome'])->name('home');
   // Route::get('/login/search','[Contactcontroller::class,'loginSearch'])->name('login_search');
   // Route::post('/manager_home',[Contactcontroller::class,'mngloginComplete'])->name('home');
    Route::get('/home/scoredata',[Contactcontroller::class,'scoreData'])->name('scoredata');
    Route::get('/manager_home/scoredata_delete',[Contactcontroller::class,'delete'])->name('scoredelete');
    Route::get('/manager_home/scoredata/scoredata_release',[Contactcontroller::class,'release'])->name('release');
    Route::get('/manager_home/scoredata/scoredata_norelease',[Contactcontroller::class,'norelease'])->name('norelease');
    Route::get('/home/scoredata/scoredata_register',[Contactcontroller::class,'scoredataRegister'])->name('scoredata_register');
    Route::post('/home/scoredata/scoredata_register',[Contactcontroller::class,'uplode'])->name('uplode');
    Route::get('/manager_home/scoredata/scoredata_detail',[Contactcontroller::class,'scoreDetail'])->name('scoreDetail');
    Route::get('/manager_home/scoredata/scoredata_edit',[Contactcontroller::class,'scoreedit'])->name('scoreedit');
    Route::post('/manager_home/scoredata/scoredata_edit',[Contactcontroller::class,'update'])->name('update');
});
//Route::post('/ajaxrelease',[Contactcontroller::class,'ajaxrelease'])->name('posts.ajaxrelease');
//Route::post('/ajaxnorelease',[Contactcontroller::class,'ajaxnorelease'])->name('posts.ajaxnorelease');


Route::get('/login',[Contactcontroller::class,'login'])->name('login');
Route::get('/logout',[Contactcontroller::class,'logout'])->name('logout');

Route::group(['middleware'=>['auth','can:user-higher']],function(){
    Route::get('/tweet',[Twittercontroller::class, 'tweet'])->name('tweet');
    Route::post('/login',[Contactcontroller::class,'loginComplete'])->name('home');
    Route::get('/register',[Contactcontroller::class,'register'])->name('register');
    Route::get('/login/search',[Contactcontroller::class,'userHome'])->name('user_home');
    Route::get('/login/record',[Contactcontroller::class,'recordpage'])->name('record_page');
    Route::get('/login/score',[Contactcontroller::class,'loginScorelink'])->name('login_scorelink');
    Route::get('/login/search',[Contactcontroller::class,'loginSearch'])->name('login_search');
    Route::get('/login/scoreedit',[Contactcontroller::class,'userScoreeditview'])->name('user_score_edit_view');
    Route::post('/login/scoreedit',[Contactcontroller::class,'userScoreedit'])->name('user_score_edit');
    Route::post('/login/search',[Contactcontroller::class,'loginSearch'])->name('login_search');
    Route::post('/register/complete',[Contactcontroller::class,'checkregister'])->name('checkregister');

});

//マイリスト
Route::post('ajaxlike', [Contactcontroller::class,'ajaxlike'])->name('posts.ajaxlike');

//パスワードリセット
Route::get('/password', [Contactcontroller::class,'userPw'])->name('user_pw');
Route::post('/password/reset', 'Contactcontroller@pwresetMail')->name('user_pw_urlmail');
Route::get('/password/reset/newpassword', 'Contactcontroller@newpassword')->name('user_newpassword');
Route::post('/password/reset/newpassword', 'Contactcontroller@update_password')->name('update_password');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
