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

Route::get('/','PagesController@home')->name('Home');
Route::get('/about','PagesController@about')->name('About');
Route::get('/contact','PagesController@contact')->name('Contact');
Route::get('/privacypolicy','PagesController@privacyPolicy')->name('PrivacyPolicy');

Route::get('/news/create','NewsController@create')->name('CreateNews');
Route::post('/news/save','NewsController@save')->name('SaveNews');
Route::get('/news/{news_id}','NewsController@detailPage')->name('NewsDetailPage');
Route::get('/news/{news_id}/edit','NewsController@edit')->name('EditNews');
Route::patch('/news/{news_id}/edit/save','NewsController@update')->name('UpdateNews');
Route::get('/news/{news_id}/delete','NewsController@delete')->name('DeleteNews');
Route::post('/news/{news_id}/store/image','NewsController@store')->name('NewsImageStore');

Route::get('/news','NewsController@overview')->name('News');
  
Route::get('/products','ProductsController@products')->name('Products');
Route::post('/products/save','ProductsController@save')->name('ProductsSave');
Route::get('/products/create','ProductsController@create')->name('ProductsCreate');
Route::get('/products/{product_id}/edit','ProductsController@edit')->name('ProductsEdit');
Route::patch('/products/{product_id}/edit/save','ProductsController@update')->name('ProductsUpdate');
Route::get('/products/{product_id}/delete','ProductsController@delete')->name('ProductsDelete');
Route::get('/products/{product_id}','ProductsController@detailPage')->name('ProductsDetailPage');
Route::post('/products/{product_id}/comment','ProductsController@comment')->name('ProductsComment');
Route::post('/products/{product_id}/fund','ProductsController@fund')->name('ProductsFund');
Route::get('/products/{product_id}/spotlight','ProductsController@spotlight')->name('ProductsSpotlight');
Route::post('/products/{product_id}/store/image','ProductsController@store')->name('ProductImageStore');
Route::get('/products/{product_id}/pdf','ProductsController@pdf')->name('PDF');



Route::get('/profile','UserController@profile')->name('Profile');
Route::post('/profile/store/image','UserController@store')->name('ProfileImageStore');
Route::get('/credits','PaymentController@getStripeForm');

Route::post('/stripe','PaymentController@postStripePayment')->name('stripe.post');
Route::post('api/convert','APIController@postConvert')->name('converter');


Auth::routes();
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});


