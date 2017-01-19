<?php

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    'namespace' => 'Taggers\News\Controller'
    ], function() {
        Route::resource('newscategories', 'NewsCategoriesController', ['except' => ['create', 'show']]);
        Route::get('news/updatestatus/{id}', 'NewsController@updateStatus')->name('news.updatestatus');
        Route::resource('news', 'NewsController', ['except' => ['show']]);
});