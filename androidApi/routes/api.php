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
	/***** login & refresh  (users) ****/
Route::post('/v1/signup',['uses'=>'v1\\Auth\\RegiterController@register']);
Route::post('/v1/refresh',['uses'=>'v1\\Auth\\LoginController@refresh']);
Route::post('/v1/login',['uses'=>'v1\\Auth\\LoginController@login']);



/********************** get uploaded files  *********************/
Route::get('/v1/files/{hash}/{name}', 'v1\UploadController@get_file');




Route::middleware('auth:api')->group(function(){
	
Route::resource('/v1/uploads', v1\UploadController::class);


Route::resource('/v1/users', v1\UserController::class);
Route::get('/v1/auth_user', ['uses'=>'v1\\UserController@getAuthUser']);
Route::resource('/v1/childrens', v1\ChildController::class);
Route::post('/v1/updateProfile',['uses'=>'v1\\UserController@updateProfile']);

Route::post('/v1/logout',['uses'=>'v1\\Auth\\LoginController@logout']);

});
