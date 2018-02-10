<?php

/*
|--------------------------------------------------------------------------
| AbbyJanke\Dictionary Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\Meta package.
|
*/

// Admin Routes
Route::group([
  'namespace' => 'AbbyJanke\BackpackDictionary\app\Http\Controllers\Admin',
  'prefix' => config('backpack.base.route_prefix', 'admin'),
  'middleware' => ['web', 'admin'],
], function () {
  \CRUD::resource('dictionary', 'DictionaryCrudController');
});

// Web Routes
Route::group([
  'namespace' => 'AbbyJanke\BackpackDictionary\app\Http\Controllers',
  'prefix' => config('backpack.dictionary.route_prefix', 'dictionary'),
  'middleware' => ['web'],
], function () {
  Route::get('/', 'DictionaryController@index')->name('dictionary.index');
  Route::get('{slug}', 'DictionaryController@show')->name('dictionary.show');
});
