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

Route::get('/', 'PriceController@showPrice');

//Auth::routes();
//Route::post('/showVerificationCodePage', 'Auth\RegisterController@showVerificationCodePage')->name('showVerificationCodePage');
//Route::post('/checkVerificationCode', 'Auth\RegisterController@checkVerificationCode')->name('checkVerificationCode');
//Route::post('/resendVerificationCode', 'Auth\RegisterController@resendVerificationCode')->name('resendVerificationCode');
//Route::post('/idPictures', 'Auth\RegisterController@idPictures')->name('idPictures');

//Route::get('/home', 'HomeController@index')->name('home');

//Admin routes
Route::get('admin/home', 'AdminController@index');
Route::get('admin','Admin\LoginController@showLoginForm')->name('admin.showLogin');
Route::post('admin', 'Admin\LoginController@login')->name('admin.login');

//Admin users routes
Route::get('admin/users', 'Admin\UsersController@index')->name('admin.users');
Route::get('admin/users/view/{id}', 'Admin\UsersController@showUser')->name('admin.viewUser');
Route::get('admin/users/edit/{id}', 'Admin\UsersController@showEditUser')->name('admin.editUser');
Route::post('admin/users/edit/{id}', 'Admin\UsersController@editUser');
Route::delete('admin/users/{id}', 'Admin\UsersController@deleteUser')->name('admin.deleteUser');
Route::get('admin/useridimagefront/{id}', 'Admin\UsersController@getUserIdCardImageFront')->name('admin.getUserIdCardImageFront');
Route::get('admin/useridimageback/{id}', 'Admin\UsersController@getUserIdCardImageBack')->name('admin.getUserIdCardImageBack');
//Admin provision routes
Route::get('admin/provision', 'Admin\ProvisionController@showProvision')->name('admin.showProvision');
Route::post('admin/provision', 'Admin\ProvisionController@saveProvision')->name('admin.saveProvision');
//Admin categories routes
Route::get('admin/categories', 'Admin\CategoriesController@showCategories')->name('admin.showCategories');
Route::delete('admin/categories/{id}', 'Admin\CategoriesController@deleteCategory')->name('admin.deleteCategory');
Route::post('admin/categories', 'Admin\CategoriesController@createCategory')->name('admin.createCategory');
//Admin crypto currencies routes
Route::get('admin/currencies', 'Admin\CryptoCurrencyController@showCurrencies')->name('admin.showCurrencies');
Route::post('admin/currencies', 'Admin\CryptoCurrencyController@createCryptoCurrency')->name('admin.createCryptoCurrency');
Route::delete('admin/currencies/{id}', 'Admin\CryptoCurrencyController@deleteCryptoCurrency')->name('admin.deleteCryptoCurrency');
//Admin orders routes
Route::get('admin/orders', 'Admin\OrderController@showOrders')->name('admin.showOrders');
Route::put('admin/orders/{id}', 'Admin\OrderController@updateOrder')->name('admin.updateOrder');
Route::post('admin/orders/{id}', 'Admin\OrderController@updateOrderSuccess')->name('admin.updateOrderSuccess');
Route::delete('admin/orders/{id}', 'Admin\OrderController@deleteOrder')->name('admin.deleteOrder');

//User routes
//Route::get('user/myAccount', 'UserController@index')->name('user.myAccount');
//Route::get('user/myAccount/changePassword', 'UserController@showChangePasswordPage')->name('user.myAccount.showChangePassword');
//Route::post('user/myAccount/changePassword', 'UserController@changePassword')->name('user.myAccount.changePassword');
//Route::get('user/myAccount/changePersonalData', 'UserController@showChangePersonalDataPage')->name('user.myAccount.showChangePersonalData');
//Route::post('user/myAccount/changePersonalData', 'UserController@changePersonalData')->name('user.myAccount.changePersonalData');
//Route::get('user/myAccount/addBankAccount', 'UserController@showAddBankAccount')->name('user.myAccount.showAddBankAccount');
//Route::post('user/myAccount/addBankAccount', 'UserController@addBankAccount')->name('user.myAccount.addBankAccount');
//Route::delete('user/myAccount/deleteBankAccount/{id}', 'UserController@deleteBankAccount')->name('user.myAccount.deleteBankAccount');
//Route::get('user/buysell', 'BuySellController@showBuySell')->name('user.buysell');
//Route::post('user/buysell', 'BuySellController@saveOrder')->name('user.buysell.saveOrder');

//Route::get('price', 'PriceController@getPrice');
Route::get('/login', 'Auth\LoginController@refresh');
Route::get('/registration', 'Auth\LoginController@refresh');
Route::get('/buy', 'Auth\LoginController@refresh');
Route::get('/buy-wallet', 'Auth\LoginController@refresh');
Route::get('/buy-complete', 'Auth\LoginController@refresh');
Route::get('/sell', 'Auth\LoginController@refresh');
Route::get('/sell-complete', 'Auth\LoginController@refresh');
