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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('import')->group(function () {
    //上传文件首页
    Route::get('index','Demo\UserImportController@index');
    Route::post('upload','Demo\UserImportController@upload');
    //测试控制器
    Route::get('test/index','Demo\TestController@index');
    Route::get('test/queue','Demo\TestController@queue');
});