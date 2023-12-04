<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\UploadController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ContactController;

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
