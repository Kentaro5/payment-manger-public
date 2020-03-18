<?php

app()->singleton('mailchimp', function(){
    return new \App\Sdk\Mailchimp\Mailchimp();
});

app()->singleton('paypal', function(){
    return new \App\Sdk\Paypal\PayPal();
});
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

Auth::routes();

Route::get('/',  function () {
   abort(404);
});

Route::get('/register',  function () {
   abort(404);
});

Route::get('/password/reset',  function () {
   abort(404);
});


Route::get('/guildpress/paypal-api', 'PublicController\PayPalApiController@index');
Route::get('/guildpress/paypal-api/test', 'PublicController\PayPalApiController@test');

Route::get('/guildpress/thank-you', 'PublicController\ThankYou\GuildPressController@index');

Route::get('/guildpress/mail/{plan_password}', 'PublicController\MailForm\MailFormController@index');
Route::get('/guildpress/mail', 'PublicController\MailForm\MailFormController@show_payment_page');
Route::post('/guildpress/mail', 'PublicController\MailForm\MailFormController@store_first_user_data');
Route::post('/guildpress/payment', 'PublicController\MailForm\MailFormController@payment');


Route::get('/i9NH/admin', 'Admin\DashboardController@index');

Route::get('/i9NH/admin/setting/mailchimp/', 'Admin\MailChimpController@index');
Route::post('/i9NH/admin/setting/mailchimp/', 'Admin\MailChimpController@store');
Route::post('/i9NH/admin/setting/mailchimp/{mailchimp}', 'Admin\MailChimpController@update');


Route::get('/i9NH/admin/setting/paypal/', 'Admin\PayPalController@index');
Route::post('/i9NH/admin/setting/paypal/', 'Admin\PayPalController@store');
Route::post('/i9NH/admin/setting/paypal/{paypal}', 'Admin\PayPalController@update');

Route::get('/i9NH/admin/paypal/list', 'Admin\PayPalListController@index');
Route::get('/i9NH/admin/paypal/list/new', 'Admin\PayPalListController@new');
Route::post('/i9NH/admin/paypal/list/new', 'Admin\PayPalListController@store');
Route::get('/i9NH/admin/paypal/list/edit/{paypal_id}', 'Admin\PayPalListController@edit');
Route::post('/i9NH/admin/paypal/list/edit/{paypal_id}', 'Admin\PayPalListController@update');
Route::post('/i9NH/admin/paypal/list/delete/{paypal_id}', 'Admin\PayPalListController@delete');









