<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Customer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'customer'], function () {
    Route::post('login', 'API\FirebaseLoginController@loginCustomer');

    Route::post('logout', 'API\FirebaseLoginController@logout')->middleware('auth:customer-api');
    Route::get('user', 'API\FirebaseLoginController@userMitra')->middleware('auth:customer-api');
});

Route::group(['prefix' => 'mitra'], function () {
    Route::post('login', 'API\FirebaseLoginController@loginMitra');

    Route::post('logout', 'API\FirebaseLoginController@logout')->middleware('auth:mitra-api');
    Route::get('user', 'API\FirebaseLoginController@userMitra')->middleware('auth:mitra-api');
});

// API ROUTE
Route::group(['prefix' => 'v1'], function () {
    // MITRA
    Route::apiResource('mitras', 'API\Mitra\MitraController');
    Route::post('mitras/{id}/avatar', 'API\Mitra\UpdateAvatar');

    // MITRA-CATEGORY
    Route::get('mitras/{mitra}/categories', 'API\MitraCategory\MitraCategoryController@index');
    Route::post('mitras/{mitra}/categories', 'API\MitraCategory\MitraCategoryController@store');

    // CATEGORY
    Route::apiResource('categories', 'API\Category\CategoryController');

    // CATEGORY-MITRA
    Route::get('categories/{category}/mitras', 'API\CategoryMitra\CategoryMitraController@index');

    // SKILLS
    Route::post('skills', 'API\Skill\SkillController@store');
    Route::get('skills', 'API\Skill\SkillController@query');

    // SKILL-MITRA
    Route::get('skills/{skill}/mitras', 'API\SkillMitra\SkillMitraController@index');

    // MITRA-SKILL
    Route::get('mitras/{mitra}/skills', 'API\MitraSkill\MitraSkillController@index');
    Route::post('mitras/{mitra}/skills', 'API\MitraSkill\MitraSkillController@store');

    // CUSTOMER
    Route::apiResource('customers', 'API\Customer\CustomerController');
    Route::post('customers/{id}/avatar', 'API\Customer\CustomerController@updateAvatar');

    // ORDER
    Route::apiResource('orders', 'API\Order\OrderController')->except(['delete']);

    // CUSTOMER-ORDER
    Route::get('customers/{customer}/orders', 'API\CustomerOrder\CustomerOrderController@index');
    Route::get('customers/{customer}/orders/processed', 'API\CustomerOrder\CustomerOrderController@processed');
    Route::get('customers/{customer}/orders/canceled', 'API\CustomerOrder\CustomerOrderController@canceled');
    Route::get('customers/{customer}/orders/finished', 'API\CustomerOrder\CustomerOrderController@finished');

    // MITRA-ORDER


    // FEEDBACK
    Route::apiResource('reviews', 'API\Review\ReviewController')->except(['update', 'destroy']);

    // CUSTOMER-REVIEW
    Route::get('customers/{customer}/reviews', 'API\Customer\CustomerReviewController@index');

    // MITRA-REVIEW
    Route::get('mitras/{mitra}/reviews', 'API\Mitra\MitraReviewController@index');

    // ADDRESS
    Route::apiResource('addresses', 'API\Address\AddressController');

    // CUSTOMER-ADDRESS
    Route::get('customers/{customer}/addresses', 'API\Customer\CustomerAddressController@index');

    // QUOTE
    Route::apiResource('quotes', 'API\Quote\QuoteController');
    Route::get('quotes/latest', 'API\Quote\QuoteController@latest');
    Route::post('quotes/{id}/image', 'API\Quote\QuoteController@image');
});
