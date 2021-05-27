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

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@log_out')->middleware('auth:airlock');
Route::post('register', 'Auth\RegisterController@register');

// 给路由分组
Route::group(['prefix'=>'blog'],function (){
//    获取博客分类
    Route::post('blogType',[\App\Http\Controllers\Blog\BlogController::class,'getBlogType']);
//    上传路由
    Route::post('upload',[\App\Http\Controllers\Blog\BlogController::class,'upload']);
//    删除图片路由
    Route::post('delImg',[\App\Http\Controllers\Blog\BlogController::class,'delImg']);
//    发布博客
    Route::post('addBlog',[\App\Http\Controllers\Blog\BlogController::class,'addBlog'])->middleware('auth:airlock');
//    获取所有博客/根据时间获取博客
    Route::get('allBlog',[\App\Http\Controllers\Blog\BlogController::class,'getAllBolg']);
//    根据id获取博客
    Route::post('myBlog',[\App\Http\Controllers\Blog\BlogController::class,'myBlog'])->middleware('auth:airlock');
//    修改博客
    Route::post('upBlog',[\App\Http\Controllers\Blog\BlogController::class,'upBlog'])->middleware('auth:airlock');
//    根据博客id获取博客
    Route::get('blogId/{id}',[\App\Http\Controllers\Blog\BlogController::class,'blogId']);
//    移除图片
    Route::post('imgdel',[\App\Http\Controllers\Blog\BlogController::class,'imgdel'])->middleware('auth:airlock');
//    删除博客
    Route::post('delblog',[\App\Http\Controllers\Blog\BlogController::class,'delblog'])->middleware('auth:airlock');
//    发表评论
    Route::post('content',[\App\Http\Controllers\Blog\BlogController::class,'content'])->middleware('auth:airlock');
//    修改/添加用户图片
    Route::post('addUserImg',[\App\Http\Controllers\Blog\BlogController::class,'addUserImg'])->middleware('auth:airlock');
//    修改/添加用户简介
    Route::post('addJianJie',[\App\Http\Controllers\Blog\BlogController::class,'addJianJie'])->middleware('auth:airlock');
//    获取用户信息
    Route::post('getUser',[\App\Http\Controllers\Blog\BlogController::class,'getUser'])->middleware('auth:airlock');
//    搜索博客
    Route::post('sousuo',[\App\Http\Controllers\Blog\BlogController::class,'sousuo']);
//    根据博客类型获取博客
    Route::post('getTypeBlog',[\App\Http\Controllers\Blog\BlogController::class,'getTypeBlog']);
});
