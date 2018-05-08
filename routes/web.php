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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/about', function () { //link that will be seen in broser
    return view('pages.about');	//redirection
});

//Route::get('/bloglist', 'BloglistController@index')->name('bloglist');
//Route::get('/bloglist/create', 'BloglistController@create')->name('create');

Route::resource('bloglist','BloglistController');