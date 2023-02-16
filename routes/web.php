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


//Home
Route::get('/', 'Admin\HomeController@index')->name('home');

//Dashboard
Route::get('dashboard', 'Admin\ProfileController@getDashboard')->middleware("logged")->name('dashboard');

//Authentication routes
Route::get('login', 'Admin\ProfileController@getLogin')->name('login');
Route::post('login', 'Admin\ProfileController@postLogin');
Route::get('register', 'Admin\ProfileController@getRegister')->name('register');
Route::post('register', 'Admin\ProfileController@postRegister');
Route::get('logout', 'Admin\ProfileController@logout')->name('logout');

//Admin
Route::get('admin/dashboard', 'Admin\AdminController@getAdminDashboard')->middleware("logged")->name('admin_dashboard');
Route::get('admin/autocomplete', 'Admin\AdminController@autocomplete')->name('autocomplete');

//Admin - Users
Route::get('admin/users','Admin\UsersController@getIndex')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_users","edit_users","trash_users"]}')->name('admin_users');
Route::get('admin/users/get', 'Admin\UsersController@getList')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_users","edit_users","trash_users"]}')->name('get_admin_users');
Route::get('admin/users/create', 'Admin\UsersController@getCreate')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_users"]}')->name('admin_users_create');
Route::post('admin/users/create', 'Admin\UsersController@create')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_users"]}')->name('admin_users_create');
Route::get('admin/users/edit/{user_id}', 'Admin\UsersController@getEdit')->middleware("logged")->middleware('Permissions:{"permissions_and":["edit_users"]}')->name('admin_users_edit');
Route::post('admin/users/edit', 'Admin\UsersController@update')->middleware("logged")->middleware('Permissions:{"permissions_and":["edit_users"]}')->name('admin_users_update');
Route::get('admin/users/trash/{user_id}', 'Admin\UsersController@Trash')->middleware("logged")->middleware('Permissions:{"permissions_and":["trash_users"]}')->name('admin_users_trash');
Route::get('admin/myprofile', 'Admin\UsersController@getMyProfile')->middleware("logged")->name('admin_users_profile');
Route::post('admin/myprofile', 'Admin\UsersController@updateProfile')->middleware("logged")->name('admin_users_update_profile');

//Admin - Posts
Route::get('admin/posts','Admin\PostsController@getIndex')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_posts","edit_posts","trash_posts"]}')->name('admin_posts');
Route::get('admin/posts/get', 'Admin\PostsController@getList')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_posts","edit_posts","trash_posts"]}')->name('get_admin_posts');
Route::get('admin/posts/create', 'Admin\PostsController@getCreate')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_posts"]}')->name('admin_posts_create');
Route::post('admin/posts/create', 'Admin\PostsController@create')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_posts"]}')->name('admin_posts_create');
Route::get('admin/posts/edit/{post_id}', 'Admin\PostsController@getEdit')->middleware("logged")->middleware('Permissions:{"permissions_and":["edit_posts"]}')->name('admin_posts_edit');
Route::post('admin/posts/edit', 'Admin\PostsController@update')->middleware("logged")->middleware('Permissions:{"permissions_and":["edit_posts"]}')->name('admin_posts_update');
Route::get('admin/posts/trash/{post_id}', 'Admin\PostsController@Trash')->middleware("logged")->middleware('Permissions:{"permissions_and":["trash_posts"]}')->name('admin_posts_trash');
Route::get('admin/posts/view/{post_id}', 'Admin\PostsController@getView')->middleware("logged")->name('admin_posts_view');


//Admin - Comments
Route::get('admin/comments','Admin\CommentsController@getIndex')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_comments","edit_comments","trash_comments"]}')->name('admin_comments');
Route::get('admin/comments/get', 'Admin\CommentsController@getList')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_comments","edit_comments","trash_comments"]}')->name('get_admin_comments');
Route::post('admin/comments/create', 'Admin\CommentsController@create')->middleware("logged")->middleware('Permissions:{"permissions_and":["create_comments"]}')->name('admin_comments_create');
Route::get('admin/comments/edit/{comment_id}', 'Admin\CommentsController@getEdit')->middleware("logged")->middleware('Permissions:{"permissions_and":["edit_comments"]}')->name('admin_comments_edit');
Route::post('admin/comments/edit', 'Admin\CommentsController@update')->middleware("logged")->middleware('Permissions:{"permissions_and":["edit_comments"]}')->name('admin_comments_update');
Route::get('admin/comments/trash/{comment_id}', 'Admin\CommentsController@Trash')->middleware("logged")->middleware('Permissions:{"permissions_and":["trash_comments"]}')->name('admin_comments_trash');