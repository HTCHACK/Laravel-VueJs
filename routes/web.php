<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Series;


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

Route::get('/', function () {
    return view('front', ['featuredSeries' => Series::take(3)->latest()->get()]);
});

Route::get('social-login/{provider}','Auth\LoginController@redirectToProvider')->name('social-login.redirect');
Route::get('social-login/{provider}/callback','Auth\LoginController@handleProviderCallback')->name('social-login.callback');

Route::resource('/series', 'SeriesController')->middleware('auth');
Route::get('/series/{series}/episodes/{episodeNumber}', 'SeriesController@episode')->name('series.episode')
->middleware(['auth','check-subscription']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');





Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('payment','PaymentController@payment')->name('payment');
Route::post('subscribe','PaymentController@subscribe')->name('subscribe');


Route::get('/subscription', ['as'=>'home','uses'=>'SubscriptionController@index'])->name('subscription');
Route::post('order-post', ['as'=>'order-post','uses'=>'SubscriptionController@orderPost']);
