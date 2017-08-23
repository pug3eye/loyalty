<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// main page.
// Route::get('/', 'WelcomeController@index');

// Route about auth.
Route::get('login', 'WelcomeController@getLogin');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');

// Route about signup.
Route::get('signup', 'WelcomeController@getSignup');
Route::post('signup', 'SignupController@store');

// Route about edit shop.
Route::get('edit', 'ShopController@edit');
Route::post('edit', 'ShopController@update');
Route::post('edit/logo', 'ShopController@destroyLogo');

// Route about redeem reward.
Route::get('redeem', 'RewardController@showRedeem');
Route::post('redeem', 'RewardController@redeem');
Route::post('redeem/result', 'RewardController@redeemResult');

// Route about product.
Route::get('product', 'ProductController@index');
Route::get('product/add', 'ProductController@create');
Route::post('product/add', 'ProductController@store');
Route::get('product/{id}', 'ProductController@show');
Route::post('product/{id}', 'ProductController@destroy');
Route::get('product/{id}/edit', 'ProductController@edit');
Route::post('product/{id}/edit', 'ProductController@update');
Route::post('product/{id}/image', 'ProductController@destroyImage');

// Route about reward.
Route::get('reward', 'RewardController@index');
Route::get('reward/add', 'RewardController@create');
Route::get('reward/redeem/history', 'RewardController@redeemHistories');
Route::post('reward/add', 'RewardController@store');
Route::get('reward/{id}', 'RewardController@show');
Route::post('reward/{id}', 'RewardController@destroy');
Route::get('reward/{id}/edit', 'RewardController@edit');
Route::post('reward/{id}/edit', 'RewardController@update');
Route::post('reward/{id}/image', 'RewardController@destroyImage');

// Route about member.
Route::get('member', 'MemberController@index');
Route::get('member/request', 'MemberController@request');
Route::get('member/{id}', 'MemberController@show');
Route::post('member/{id}', 'MemberController@destroy');
Route::post('member/{id}/accept', 'MemberController@accept');
Route::post('member/{id}/delete', 'MemberController@delete');

// Route about sales product.
Route::get('sale', 'SaleController@index');
Route::post('sale', 'SaleController@completeSale');
Route::get('sale/product/search', 'SaleController@getProductsList');
Route::get('sale/product/all', 'SaleController@allProducts');
Route::get('sale/product/all/{id}', 'SaleController@selectFromAllProducts');
Route::get('sale/member/search', 'SaleController@getMembersList');
Route::get('sale/product/{id}', 'SaleController@storeSaleProduct');
Route::get('sale/member/{id}', 'SaleController@storeBuyMember');
Route::get('sale/member', 'SaleController@clearBuyMember');
Route::get('sale/product/{barcode}/delete', 'SaleController@deleteSaleProduct');
Route::post('sale/product/{barcode}/update', 'SaleController@updateSaleProduct');
Route::get('sale/clear', 'SaleController@clearSale');

// Route for android application.
Route::post('customer/signup', 'CustomerController@store'); // signup. ok
Route::post('customer/login', 'CustomerController@login'); // login. ok
Route::post('customer/member/register', 'MemberController@register'); // register member. ok
Route::post('customer/redeem/reward', 'MemberController@redeemReward'); // redeem reward. ok
Route::post('customer/members', 'MemberController@showMembers'); // show members of customer. ok
Route::post('customer/shop/{id}/member', 'MemberController@pointHistories'); // show point history. ok
Route::post('customer/shop/{id}/rewards', 'MemberController@showRewardsAndMemberPoint'); // show rewards and rewards detail of shop. ok
Route::get('customer/shop/{id}', 'MemberController@showShopDetail'); // show shop detail. ok
Route::get('customer/search/shops', 'MemberController@searchShop'); // search shop. ok

// Route about branch.
Route::get('branch', 'BranchController@index');
Route::get('branch/add', 'BranchController@create');
Route::post('branch/add', 'BranchController@store');
Route::get('branch/{id}', 'BranchController@show');
Route::post('branch/{id}', 'BranchController@destroy');
Route::get('branch/{id}/edit', 'BranchController@edit');
Route::post('branch/{id}/edit', 'BranchController@update');
Route::post('branch/{id}/image', 'BranchController@destroyImage');

// Admin Route.
Route::group(['prefix' => 'admin'], function()
{

  Route::get('login', 'AdminLoginController@showLogin');
  Route::post('login', 'AdminLoginController@login');
  Route::get('logout', 'AdminLoginController@logout');

  Route::get('dashboard', 'AdminDashboardController@index');

  Route::get('customer', 'AdminCustomerController@index');
  Route::post('customer/add', 'AdminCustomerController@store');
  Route::get('customer/{id}', 'AdminCustomerController@show');
  Route::post('customer/{id}', 'AdminCustomerController@destroy');
  Route::get('customer/{id}/edit', 'AdminCustomerController@edit');
  Route::post('customer/{id}/edit', 'AdminCustomerController@update');

  Route::get('shop', 'AdminShopController@index');
  Route::post('shop/add', 'AdminShopController@store');
  Route::get('shop/{id}', 'AdminShopController@show');
  Route::post('shop/{id}', 'AdminShopController@destroy');
  Route::get('shop/{id}/edit', 'AdminShopController@edit');
  Route::post('shop/{id}/edit', 'AdminShopController@update');
  Route::post('shop/{id}/logo', 'AdminShopController@destroyLogo');

  Route::get('product', 'AdminProductController@index');
  Route::get('product/{id}', 'AdminProductController@show');
  Route::post('product/{id}', 'AdminProductController@destroy');

  Route::get('reward', 'AdminRewardController@index');
  Route::get('reward/{id}', 'AdminRewardController@show');
  Route::post('reward/{id}', 'AdminRewardController@destroy');

  Route::get('member', 'AdminMemberController@index');
  Route::get('member/{id}', 'AdminMemberController@show');
  Route::post('member/{id}', 'AdminMemberController@destroy');

});

Route::get('test', 'MemberController@testGenerate');

// Create admin.
Route::get('create/admin', 'CreateAdminController@createAdmin');
