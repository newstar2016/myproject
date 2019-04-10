<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//查询导入记录列表
Route::get('records/list', 'Demo\Api\RecordController@list');
//查询导入记录详情
Route::get('records/info/{importsn}', 'Demo\Api\RecordController@info');