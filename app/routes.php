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

    Route::post('/', 'UsersController@store');

    Route::group(['prefix' => '/{userId}', ], function() {

        Route::get('/', 'UsersController@show');

        Route::group(['prefix' => '/todos'], function() {

            Route::get('/', 'TodosController@index');
            Route::post('/', 'TodosController@store');
            Route::get('/{todoId}', 'TodosController@show');
            Route::put('/{todoId}', 'TodosController@update');
            Route::delete('/{todoId}', 'TodosController@destroy');

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
