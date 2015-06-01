<?php

/*
|--------------------------------------------------------------------------
| アプリケーションのルート
|--------------------------------------------------------------------------
|
| ここでアプリケーションのルートを全て登録することが可能です。
| 簡単です。ただ、Laravelへ対応するURIと、そのURIがリクエスト
| されたときに呼び出されるコントローラーを指定してください。
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('/ping', function() {
    return response()->json(['hello'=>'world']);
});


// タイトル情報取得API群
Route::get('/title/get-all', 'TitleController@getAll');
Route::get('/title/info/{id}', 'TitleController@info');
Route::get('/title/token/{id}', 'TitleController@token');
Route::get('/title', 'TitleController@index');

// ユーザー情報取得API群
Route::get('/user/get-all', 'UserController@getAll');
Route::get('/user/token/{id}', 'UserController@getToken');
Route::get('/user', 'UserController@index');

// セーブデータ操作API群
Route::post('/savedata/save/{user_id}/{title_id}', 'SavedataController@save');
Route::get('/savedata/load/{user_id}/{title_id}', 'SavedataController@load');
Route::get('/savedata/create/{user_id}/{title_id}', 'SavedataController@create');
Route::get('/savedata/delete/{user_id}/{title_id}', 'SavedataController@delete');
Route::get('savedata', 'SavedataController@index');

/**
 * ☆☆☆ ここから下は分離作業中 ☆☆☆
 **/

Route::get('home', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


/*
Route::group(['before' => 'api_auth'], function() {
});
*/

Route::get('login', ['uses' => 'HomeController@showLogin']);
Route::post('login', ['uses' => 'HomeController@doLogin']);
/*
Route::get('game', function() {
    return view("game");
});
*/
Route::group(['middleware' => 'auth'], function() {
    Route::get('game/attack', 'GameController@attack');
    Route::get('game/heal',   'GameController@heal');
    Route::get('game/buy',    'GameController@buy');
    Route::get('game/create', 'GameController@create');
    Route::get('game/delete', 'GameController@delete');
    Route::get('game/load',   'GameController@load');
    Route::get('game/save',   'GameController@save');
    Route::get('game/reset_monster', 'GameController@reset_monster');
    Route::get('game',        'GameController@index');

});

Route::get('info', function() {
    return View('phpinfo');
});

