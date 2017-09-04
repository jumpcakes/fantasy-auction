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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/players','PlayersController@index');
Route::get('/get_max_bid/{user}','PlayersController@maxBid');

Route::post('/save_pick','PlayersController@pickPlayer');
Route::post('/save_bid','PlayersController@bidOnPlayer');
Route::post('/auction_winner','PlayersController@auctionWinner');

Route::post('/push','PagesController@pushMessage');
Route::post('/set_pick_order', 'PagesController@promptPick');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


