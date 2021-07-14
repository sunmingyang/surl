<?php

Route::post('/', 'IndexController@encode')->name('surl.encode');
Route::get('{code}', 'IndexController@decode')->name('surl.decode');
