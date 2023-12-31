<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Panel\admin\BrandController;
use App\Http\Controllers\Panel\admin\CategoryController;
use App\Http\Controllers\Panel\admin\PackageTypeController;
use App\Http\Controllers\Panel\admin\TagController;
use App\Http\Controllers\Panel\admin\ProducerController;
use App\Http\Controllers\Panel\admin\UserController;
use App\Http\Controllers\Panel\admin\ProductController;
use App\Http\Controllers\Panel\admin\DiscountController;
use App\Http\Controllers\Panel\admin\GalleryController;
use App\Http\Controllers\Panel\admin\CommentController;
use App\Http\Controllers\Panel\admin\ProfileController;
use App\Http\Controllers\Panel\admin\ScoreController;
use App\Http\Controllers\Panel\admin\LikeController;
use App\Http\Controllers\Panel\admin\ContactUsController;
use App\Http\Controllers\Panel\admin\StoreProfileController;
use App\Http\Controllers\Panel\admin\SocialMediaController;
use App\Http\Controllers\Panel\customer\ProfileCustomerController;
use App\Http\Controllers\Panel\admin\AdminDashboardController;
use App\Http\Controllers\Panel\customer\CustomerDashboardController;
use App\Http\Controllers\Panel\admin\OrderController;
use App\Http\Controllers\Panel\admin\FactorController;
use App\Http\Controllers\Panel\admin\PaymentController;
use App\Http\Controllers\Panel\customer\OrderCustomerController;
use App\Http\Controllers\Panel\admin\AdminFactorController;
use App\Http\Controllers\Panel\customer\CustomerFactorController;
use App\Http\Controllers\Panel\customer\FavoritesController;
use App\Http\Controllers\UserPages\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource("login",LoginController::class); // set API
Route::resource("register",RegisterController::class); // set API
Route::post('contactUs',[IndexController::class,"CreateContactUs"]); // done
Route::get('storeProfile',[IndexController::class,"StoreProfile"]); // done
Route::get('socialMedias',[IndexController::class,"SocialMedias"]); // done
Route::post('orders',[IndexController::class,"UserBasket"]); // done
Route::post('orders/save',[IndexController::class,"CreateOrder"]); // done // save and add order
Route::post('orders/redus',[IndexController::class,"RedusOrder"]); // done // delete order
Route::post('factor',[IndexController::class,"CreateFactor"]); // done
Route::post('payment',[IndexController::class,"CreatePayment"]); // done
Route::get('category',[IndexController::class,"Categories"]); // done
Route::get('brand',[IndexController::class,"Brands"]); // done
Route::get('product',[IndexController::class,"Products"]); // done
Route::get('product/comments/{id}',[IndexController::class,"ProductComments"]); // done
Route::post('product/comment/save',[IndexController::class,"CreateComment"]); // done
Route::get('discount',[IndexController::class,"Discounts"]); // done
Route::get('moreScoreProduct',[IndexController::class,"MoreScoreProduct"]); // done
Route::post('searchProduct',[IndexController::class,"SearchProducts"]); // done
Route::post('product/score/save',[IndexController::class,"CreateScore"]); // done
Route::post('product/score/user',[IndexController::class,"UserScore"]); // done
Route::post('product/like/save',[IndexController::class,"CreateLike"]); // done
Route::post('product/like/user',[IndexController::class,"UserLike"]); // done
Route::get('product/detail/{id}',[IndexController::class,"ProductDetail"]); // done
Route::get('brandProduct/{id}',[IndexController::class,"GetProductByBrand"]); // done
Route::get('categoryProduct/{id}',[IndexController::class,"GetProductByCategory"]); // done
Route::middleware("admin")->group(function(){
    Route::resource('dashboard-A',AdminDashboardController::class); // done
    Route::resource('admin',ProfileController::class); // done
    Route::resource("users",UserController::class); // done
    Route::resource("categories",CategoryController::class); // done
    Route::resource("brands",BrandController::class); // done
    Route::resource("producers",ProducerController::class); // done
    Route::resource("packageTypes",PackageTypeController::class); // done
    Route::resource("tags",TagController::class); // done
    Route::resource("products",ProductController::class); // done
    Route::resource("discounts",DiscountController::class); // done
    Route::resource("galleries",GalleryController::class);// done
    Route::resource("comments",CommentController::class); // done
    Route::resource("scores",ScoreController::class); // done
    Route::resource("likes",LikeController::class); // done
    Route::resource("contacts",ContactUsController::class); // done
    Route::resource("profile",StoreProfileController::class); // done
    Route::resource("medias",SocialMediaController::class); // done
    Route::resource('cart',OrderController::class); // done
    Route::resource('factors',AdminFactorController::class); // done
});
Route::middleware("customer")->group(function(){
    Route::resource('dashboard-C',CustomerDashboardController::class); // done
    Route::resource('customer',ProfileCustomerController::class); // done
    Route::resource('basket',OrderCustomerController::class); // done
    Route::resource('lists',CustomerFactorController::class); // done
    Route::resource('favorites',FavoritesController::class); // done
});
