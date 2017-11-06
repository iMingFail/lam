<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::post('logout', 'LoginController@logout');

Route::get('/', 'IndexController@index');


Route::get('index', ['as' => 'admin.index', 'uses' => function () {
    return redirect('/admin/log-viewer');
}]);


Route::group(['middleware' => ['auth:admin', 'menu', 'authAdmin']], function () {
    //权限管理路由
    Route::get('permission/{cid}/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::get('permission/manage', ['as' => 'admin.permission.manage', 'uses' => 'PermissionController@index']);
    Route::get('permission/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::post('permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']); //查询
    Route::resource('permission', 'PermissionController', ['names' => ['update' => 'admin.permission.edit', 'store' => 'admin.permission.create']]);

    //角色管理路由
    Route::get('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::post('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::resource('role', 'RoleController', ['names' => ['update' => 'admin.role.edit', 'store' => 'admin.role.create']]);

    //用户管理路由
    Route::get('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);  //用户管理
    Route::post('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::resource('user', 'UserController', ['names' => ['update' => 'admin.user.edit', 'store' => 'admin.user.create']]);

	
	//迅联数据路由
	Route::get('xunlian/manage', ['as' => 'admin.xunlian.manage', 'uses' => 'XunlianController@index']);
	Route::get('xunlian/index', ['as' => 'admin.xunlian.index', 'uses' => 'XunlianController@index']);  //客户列表
    Route::post('xunlian/index', ['as' => 'admin.xunlian.index', 'uses' => 'XunlianController@index']);
    Route::resource('xunlian', 'XunlianController', ['names' => ['update' => 'admin.xunlian.edit', 'store' => 'admin.xunlian.create']]);
	
	//迅联商户号管理
	Route::get('merchant/{cid}/create', ['as' => 'admin.merchant.create', 'uses' => 'MerchantController@create']);
	Route::get('merchant/index', ['as' => 'admin.merchant.index', 'uses' => 'MerchantController@index']);
	Route::get('merchant/{cid?}/index', ['as' => 'admin.merchant.index', 'uses' => 'MerchantController@index']);
	//Route::get('merchant/index', ['as' => 'admin.merchant.index', 'uses' => 'MerchantController@index']);  //商户号列表
    Route::post('merchant/index', ['as' => 'admin.merchant.index', 'uses' => 'MerchantController@index']);
    Route::resource('merchant', 'MerchantController', ['names' => ['update' => 'admin.merchant.edit', 'store' => 'admin.merchant.create']]);
});

Route::get('/', function () {
    return redirect('/admin/index');
});

