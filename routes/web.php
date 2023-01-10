<?php

use App\Http\Controllers\ApproveTransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DenyTransactionController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Livewire\Styleguide;
use App\Http\Controllers\Livewire\VehicleSearch;
use App\Http\Controllers\Livewire\VehicleSearchTable;
use App\Http\Controllers\StartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Livewire\UserProfile;
use App\Http\Controllers\Livewire\CarUpload;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Livewire\NewUserList;
use App\Http\Controllers\Livewire\VehicleDetails;
use App\Http\Controllers\Livewire\Cart;
use App\Http\Controllers\Livewire\Analytics;

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

Route::get('/', function () {
    return redirect(route('nova.login'));
});

Route::get('nova/register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('nova.register')->middleware('enable.registration');
Route::post('nova/register', '\App\Http\Controllers\Auth\RegisterController@register')->name('nova.register.store')->middleware('enable.registration');
Route::post('nova/login', '\App\Http\Controllers\Auth\LoginController@login')->name('nova.login');

Route::post('nova/password/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset')->name('nova.reset');

Route::view('maintenance', 'maintenance')->name('maintenance');


Route::middleware(['auth'])->prefix('app')->group(function() {
    Route::get('/vehicle-search', VehicleSearch::class)->name('vehicle-search');
    Route::get('/vehicle-search/table', VehicleSearchTable::class)->name('vehicle-search-table')->middleware('role:Administrator');
    Route::get('/used-cars/{vehicle}/documents', [DocumentsController::class, 'list'])->name('used_cars.detail.documents.list');
    Route::get('/used-cars/{vehicle}/documents/{document}', [DocumentsController::class, 'get'])->name('used_cars.detail.documents.get');
    Route::get('/styleguide', Styleguide::class)->name('styleguide');
    Route::get('/start', StartController::class)->name('start');
    Route::get('/cart', Cart::class)->name('cart.index');
    Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::get('/enquiry/{userType}', [EnquiryController::class, 'list'])->name('enquiry.list')->middleware('role:Buyer|Logistics|Administrator')->middleware('redirectEnquiriesByRole');
    Route::get('/order/{userType}', [EnquiryController::class, 'list'])->name('order.list')->middleware('role:Buyer|Logistics|Administrator')->middleware('redirectEnquiriesByRole');
    Route::post('/transaction/{transaction}/approve', ApproveTransactionController::class)->name('transaction.approve')->middleware('role:Logistics|Administrator');
    Route::post('/transaction/{transaction}/deny', DenyTransactionController::class)->name('transaction.deny')->middleware('role:Logistics|Administrator');
    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::view('/faq', 'frontend.faq')->name('faq');
    Route::get('/profile', UserProfile::class)->name('user-profile');
    Route::get('/analytics/{type}', Analytics::class)->name('analytics');
    Route::get('/vehicle/{vehicle}/details', VehicleDetails::class)->name('vehicle.details');

    Route::get('/upload', CarUpload::class)->name('car.upload')->middleware('role:Uploader');
    Route::get('/upload/{upload}/status', [UploadController::class, 'show'])->name('car.upload.status')->middleware('role:Uploader');
    Route::get('/upload/{upload}', [UploadController::class, 'info'])->name('car.upload.info')->middleware('role:Uploader');

    Route::get('/new-users', NewUserList::class)->name('new-users');
    Route::view('/announcements', 'frontend.announcements')->name('announcements');
});


