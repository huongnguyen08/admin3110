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

Route::get('register',[
    'uses'=>'AdminController@getRegister',
    'as'=>'dang_ki'
]);
Route::post('register',[
    'uses'=>'AdminController@postRegister',
    'as'=>'dang_ki'
]);


Route::get('login',[
    'uses'=>'AdminController@getLogin',
    'as'=>'dang_nhap'
]);
Route::post('login',[
    'uses'=>'AdminController@postLogin',
    'as'=>'dang_nhap'
]);

Route::get('logout',[
    'uses'=>'AdminController@getLogout',
    'as'=>'dangxuat'
]);

Route::group(['prefix'=>'admin', 'middleware'=> 'adminCheck'], function(){

    Route::get('/', function () {
        return view('welcome');
    })->name('trangchu');
    

    Route::get('home',[
        'uses'=>'AdminController@getHomePage',
        'as' => 'home'
    ]);

    Route::group(['middleware'=>'isEditor'],function(){
        Route::get('edit/{id}-{alias}',[
            'uses'=>'AdminController@getEditFood',
            'as' => 'get_edit'
        ]);
        Route::post('edit/{id}',[
            'uses'=>'AdminController@postEditFood',
            'as' => 'edit'
        ]);
    });

    Route::group(['middleware'=>'isAdmin'],function(){
       
        Route::get('delete/{id}-{alias}',[
            'uses'=>'AdminController@getDeleteFood',
            'as' => 'delete'
        ]);
    
        Route::get('add-food',[
            'uses'=>'AdminController@getAddFood',
            'as' => 'add_food'
        ]);
        Route::post('add-food',[
            'uses'=>'AdminController@postAddFood',
            'as' => 'add_food'
        ]);
    });
});



Route::get('admin-login',[
    'uses'=>'Admin_2Controller@getLogin',
    'as'=>'admin_dang_nhap'
]);
Route::post('admin-login',[
    'uses'=>'Admin_2Controller@postLogin',
    'as'=>'admin_dang_nhap'
]);

Route::get('admin-logout',[
    'uses'=>'Admin_2Controller@getLogout',
    'as'=>'admin_dangxuat'
]);


Route::get('send-mail-demo',"Admin_2Controller@getSendMail");