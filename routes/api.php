<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['prefix' =>'auth','namespace' => 'Api'],function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', 'AuthenticationController@register');
        // Login User
        Route::post('login', 'AuthenticationController@login');

        // Refresh the JWT Token
        Route::get('refresh', 'AuthenticationController@refresh');

        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', 'AuthenticationController@user');
            Route::get('token_user', 'AuthenticationController@request_user');
            // Logout user from application
            Route::post('logout', 'AuthenticationController@logout');


        });
    });

    Route::group(['prefix' =>'product','namespace' => 'Api'],function () {
        Route::get('/list','ProductController@index');
        Route::get('/edit/{id}','ProductController@edit');
        Route::get('/delete/{id}','ProductController@delete');
        Route::post('/store','ProductController@store');
        Route::post('/update','ProductController@update');
    });
});
