<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Hris\Newsfeed\Http\Controllers\Admin', 
    'as' => 'admin.', 
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'verified', 'isAdmin']
], function() {
    Route::resource('newsfeeds', 'NewsfeedController')->only(['index', 'show', 'store', 'destroy']);
    Route::get('allnewsfeed', 'NewsfeedController@getAll')->name('newsfeeds.getall');
    Route::get('newsfeeds/{id}/hitlike', 'NewsfeedController@hitlike')->name('newsfeeds.hitlike');
    Route::post('newsfeeds/{id}/comment', 'NewsfeedController@comment')->name('newsfeeds.comment');
    Route::delete('newsfeeds/comment/{id}', 'NewsfeedController@deleteComment')->name('newsfeeds.deleteComment');
    Route::post('newsfeed_events', 'NewsfeedController@event')->name('newsfeeds.event');

});

Route::group([
    'namespace' => 'Hris\Newsfeed\Http\Controllers\Supervisor', 
    'as' => 'supervisor.', 
    'prefix' => 'supervisor',
    'middleware' => ['web', 'auth', 'verified', 'isSupervisor']
], function() {
    Route::resource('newsfeeds', 'NewsfeedController')->only(['index', 'show', 'store', 'destroy']);
    Route::get('allnewsfeed', 'NewsfeedController@getAll')->name('newsfeeds.getall');
    Route::get('newsfeeds/{id}/hitlike', 'NewsfeedController@hitlike')->name('newsfeeds.hitlike');
    Route::post('newsfeeds/{id}/comment', 'NewsfeedController@comment')->name('newsfeeds.comment');
    Route::delete('newsfeeds/comment/{id}', 'NewsfeedController@deleteComment')->name('newsfeeds.deleteComment');
    Route::post('newsfeed_events', 'NewsfeedController@event')->name('newsfeeds.event');

});

Route::group([
    'namespace' => 'Hris\Newsfeed\Http\Controllers\Staff', 
    'as' => 'staffs.', 
    'prefix' => 'staffs',
    'middleware' => ['web', 'auth', 'verified', 'isStaff']
], function() {
    Route::resource('newsfeeds', 'NewsfeedController')->only(['index', 'show', 'store', 'destroy']);
    Route::get('allnewsfeed', 'NewsfeedController@getAll')->name('newsfeeds.getall');
    Route::get('newsfeeds/{id}/hitlike', 'NewsfeedController@hitlike')->name('newsfeeds.hitlike');
    Route::post('newsfeeds/{id}/comment', 'NewsfeedController@comment')->name('newsfeeds.comment');
    Route::delete('newsfeeds/comment/{id}', 'NewsfeedController@deleteComment')->name('newsfeeds.deleteComment');
    Route::post('newsfeed_events', 'NewsfeedController@event')->name('newsfeeds.event');
    
});