<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\UploadController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\PhotoController;



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

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/', 'dashboard')->name('dashboard');    
    Route::post('/logout', 'logout')->name('logout');

});

Route::get('/about', function(){
    return view('about');
});

Route::get('/contact', function(){
    return view('contact');
});

Route::get('/welcome/{user_id}', [HomeController::class, 'show']);
Route::get('/about/{user_id}', [AboutController::class, 'show']);
Route::get('/contact/{user_id}', [ContactController::class, 'show']);

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/update/', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

Route::get('/pictures/{id}', [DashboardController::class, 'getUserData'])->name('dashboard.getUserData');
Route::post('/pictures/table', [DashboardController::class, 'getPictureTable']);
Route::get('/upload', [UploadController::class, 'index'])->name('upload');
Route::post('/upload', [UploadController::class, 'uploadPic'])->name('upload.uploadPic');
Route::post('/reviews', [ReviewController::class, 'sendReview'])->name('review.sendReivew');
Route::get('/statistics', [ReviewController::class, 'rankingView'])->name('review.rankingView');
Route::get('/picRankingView', [ReviewController::class, 'picRankingView'])->name('review.picRankingView');
Route::get('/ranking', [ReviewController::class, 'ranking']);
Route::get('/picranking', [ReviewController::class, 'picRanking']);
Route::get('/photos', [PhotoController::class, 'index']);
Route::get('/photos/{id}', [PhotoController::class, 'delete']);
Route::get('/comments', [ReviewController::class, 'getComments']);

// Routes for Admin
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/', 'HomeController@index');
    // User Routes
    Route::resource('user', 'UserController');
    Route::delete('user/{id}', 'UserController@destroy');
    Route::get('user/{id}/profile', 'UserController@profile');
    Route::put('user/{id}/profile', 'UserController@update_profile');
    Route::get('user/{id}/setting', 'UserController@setting');
    Route::put('user/{id}/setting', 'UserController@update_setting');
    Route::resource('image', 'ImageController');
    
});

Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');
Route::post('/register', [ContactController::class, 'suppportContact'])->name('contact.support');
Route::get('/getReivewPictures/{id}', [ReviewController::class, 'getReviewPictures'])->name('review.pictures');




