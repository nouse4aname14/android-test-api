<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => 'users'), function() {

    Route::post('/', '\Api\Controllers\UsersController@store');

    Route::group(['prefix' => '/{userId}', ], function() {

        Route::get('/', '\Api\Controllers\UsersController@show');

        Route::group(['prefix' => '/todos'], function() {

            Route::get('/', '\Api\Controllers\TodosController@index');
            Route::post('/', '\Api\Controllers\TodosController@store');
            Route::get('/{todoId}', '\Api\Controllers\TodosController@show');
            Route::put('/{todoId}', '\Api\Controllers\TodosController@update');
            Route::delete('/{todoId}', '\Api\Controllers\TodosController@destroy');

        });
    });
});

Route::post('login', function() {

    $input = Input::all();
    if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']]))
    {
        $authToken = AuthToken::create(Auth::user());
        $publicToken = AuthToken::publicToken($authToken);
        return Response::make(json_encode(['user_id' => Auth::user()->id,'auth_token' => $publicToken]), 200);
    } else {
        return Response::make(json_encode(['message' => 'Login attempt failed.']), 400);
    }

});

Route::get('auth', 'Tappleby\AuthToken\AuthTokenController@index');
Route::post('auth', 'Tappleby\AuthToken\AuthTokenController@store');
Route::delete('auth', 'Tappleby\AuthToken\AuthTokenController@destroy');

