<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BraintreeController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::fallback(function () {
    return view('admin.404');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);
    Route::resource('images', ImageController::class)->parameters(['images' => 'image:id']);
    Route::resource('messages', MessageController::class)->parameters(['message' => 'message:id']);
    Route::get('/allMessages', [MessageController::class, 'all'])->name('all_messages');
    Route::get('/allSponsorships', [SponsorshipController::class, 'all'])->name('all_sponsorships');
    Route::resource('sponsorships', SponsorshipController::class)->parameters(['sponsorship' => 'sponsorship:id']);
    Route::any('/payment', [BraintreeController::class, 'token'])->name('payment');
    Route::post('/process-transaction', [BraintreeController::class, 'processTransaction'])->name('transaction');
    Route::resource('/views', ViewController::class)->parameters(['views'=>'apartment:slug']);
});


require __DIR__ . '/auth.php';
