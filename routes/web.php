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


Route::get('/','PostController@index');

Route::get('blog/{slug}','PostController@detail');

Route::get('category/{slug}','PostController@category');

Route::get('tag/{slug}','PostController@tag');

//Route gọi đến view upload ảnh
Route::get('file','FileController@index');
//Route để lưu ảnh vào storage
Route::post('file','Filecontroller@upload');

Route::prefix('admin')->group(function() {

	Auth::routes();

	Route::middleware(['auth:web'])->group(function() {
		
		Route::get('/dashboard','AdminController@index');
		//Quản lý POST
		Route::get('posts/getlistposts','AdminPostAjaxController@getListPosts')->name('getlistposts');

		Route::delete('posts/removetag/{tag_id}','AdminPostAjaxController@removePostTag')->name('removetag');
		
		Route::resource('posts','AdminPostAjaxController');
		//Hết quản lý POST
		
		//Quản lý CATEGORY
		Route::get('getlistcategories','AdminCategoryController@getListCategories')->name('getlistcategories');
		
		Route::resource('categories','AdminCategoryController');
		//Hết quản lý CATEGORY

		//Quản lý TAG
		Route::get('getlisttags','AdminTagController@getListTags')->name('getlisttags');
		
		Route::resource('tags','AdminTagController');
		//Hết quản lý TAG
	});
});


Route::get('test', function () {
	return view('welcome');
});

Route::get('get-tag', 'TestController@getTag');


Route::post('testvalid', 'PostController@test');

Route::get('testvalid', 'PostController@getFormTest');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts', 'TestController@index');

Route::get('/getlistposts', 'TestController@getListPosts')->name('test.getlistposts');

