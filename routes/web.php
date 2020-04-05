<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'HomeController@index');
Route::resource('/navigation', 'NavigationController');

// Wiki 项目导航
Route::group(['prefix' => 'wiki', 'namespace' => 'wiki'], function () {

});


// 后台管理模块路由
Admin::routes();
Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function () {

    Route::get('/', 'DashboardController@index')->name('admin:dashboard');
    // 导航站分类管理
    Route::resource('navigation/categories', 'Navigation\CategoryController');
    // 导航站网站地址管理
    Route::resource('navigation/sites', 'Navigation\SiteController');
    // 文章管理
    Route::resource('article', 'Article\ArticleController');
    // 首页菜单配置
    Route::resource('config/nav', 'Config\NavConfigController');
    // Wiki管理
    Route::resource('wiki', 'Wiki\WikiProjectController');
    Route::group([
        'prefix' => 'wiki',
        'namespace' => 'Wiki'
    ], function () {
        Route::get('edit/{id}', 'WikiDocumentController@edit')
            ->name('wiki.document.edit')
            ->where('id', '[0-9]+');
        Route::get('content/{id}', 'WikiDocumentController@getContent')
            ->name('wiki.document.content')
            ->where('id', '[0-9]+');
        Route::post('save', 'WikiDocumentController@save')
            ->name('wiki.document.save');
        Route::post('sort/{id}', 'WikiDocumentController@sort')
            ->name('wiki.document.sort');
    });
});

// 测试
Route::get('test', 'TestController@index');
