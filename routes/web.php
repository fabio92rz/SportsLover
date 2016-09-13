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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/about', 'HomeController@about');
Route::get('/category/{category}', 'PostController@categories');

Route::get('/', 'PostController@index');
Route::get('/home', ['as' => 'home', 'uses' => 'PostController@index']);
// check for logged in user

Route::group(['middleware' => ['auth']], function () {
    // show new post form
    Route::get('new-post', 'PostController@create');
    // save new post
    Route::post('store-post', 'PostController@store');
    // show new category form
    Route::get('new-category', 'CategoryController@create');
    //save new category
    Route::post('store-category', 'CategoryController@store');
    Route::get('/new-category/{id}',[
        'uses' => 'CategoryController@delete',
        'as'   => 'categoryid'
    ]);
    //Delete category
    Route::get('delete-category/{id}', 'CategoryController@delete');
    //edit category
    Route::get('edit-category/{id}', 'CategoryController@edit');
    // edit post form
    Route::get('edit/{slug}', 'PostController@edit');
    // update post
    Route::post('update', 'PostController@update');
    // delete post
    Route::get('delete/{id}', 'PostController@destroy');
    // display user's all posts
    Route::get('my-all-posts', 'UserController@user_posts_all');
    // display user's drafts
    Route::get('my-drafts', 'UserController@user_posts_draft');
    // add comment
    Route::post('comment/add', 'CommentController@store');
    // delete comment
    Route::post('comment/delete/{id}', 'CommentController@distroy');
    //users profile
    Route::get('user/{id}', 'UserController@profile')->where('id', '[0-9]+');
    // display list of posts
    Route::get('user/{id}/posts', 'UserController@user_posts')->where('id', '[0-9]+');
    // display single post
    Route::get('/{slug}', ['as' => 'post', 'uses' => 'PostController@show'])->where('slug', '[A-Za-z0-9-_]+');

});


