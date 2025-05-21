<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\Backend\WebsiteSettingController;
use App\Http\Controllers\GoogleController;

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

// ====================== FRONTEND ======================

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('frontend.home');
});

//authentication
Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], 'sign-up', [AuthController::class, 'signup'])->name('signup');
Route::match(['get', 'post'], 'forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
Route::match(['get', 'post'], 'new-password', [AuthController::class, 'newPassword'])->name('new.password');
Route::match(['get', 'post'], 'password-reset', [AuthController::class, 'passwordReset'])->name('password.reset');
Route::get('resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

// google auth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.handle.callback');

// ====================== BACKEND =======================

// admin
Route::prefix('user')->middleware(['auth'])->group(function () {
    //profile
    Route::get('profile', [DashboardController::class, 'profile'])->name('user.profile');
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('user.update.profile');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('backend.admin.dashboard');

    Route::resource('customers','Backend\CustomerController');
    Route::post('customer-ladger','Backend\DueBookController@ladgerCreate')->name('customers.ladger.store');
    Route::put('customer-ladger/{id}','Backend\DueBookController@ladgerUpdate')->name('customers.ladger.update');
    Route::delete('customer-ladger/{id}','Backend\DueBookController@ladgerDelete')->name('customers.ladger.delete');
    Route::get('customer-due-book-close/{id}','Backend\DueBookController@dueBookClose')->name('customers.due-book.close');
    Route::get('customer-old-due-book/{id}','Backend\DueBookController@oldDueBooks')->name('customers.old-due-books');
    Route::get('customer-old-due-book-show/{id}','Backend\DueBookController@oldDueBookDetails')->name('customers.old-due-book.show');

    // Reports
    Route::prefix('reports')->group(function () {

    });
   
    Route::prefix('users')->middleware(['admin'])->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('backend.admin.users');
        Route::get('suspend/{id}/{status}', [UserManagementController::class, 'suspend'])->name('backend.admin.user.suspend');
        Route::match(['get', 'post'], 'create', [UserManagementController::class, 'create'])->name('backend.admin.user.create');
        Route::match(['get', 'post'], 'edit/{id}', [UserManagementController::class, 'edit'])->name('backend.admin.user.edit');
        Route::get('delete/{id}', [UserManagementController::class, 'delete'])->name('backend.admin.user.delete');
    });


    // settings
    Route::prefix('settings')->group(function () {
        // website settings
        Route::prefix('website')->group(function () {
            Route::controller(WebsiteSettingController::class)->prefix('general')->group(function () {
                Route::get('/', 'websiteGeneral')->name('backend.admin.settings.website.general');
                Route::post('update-info', 'websiteInfoUpdate')->name('backend.admin.settings.website.info.update');
                Route::post('update-contacts', 'websiteContactsUpdate')->name('backend.admin.settings.website.contacts.update');
                Route::post('update-social-links', 'websiteSocialLinkUpdate')->name('backend.admin.settings.website.social.link.update');
                Route::post('update-style-settings', 'websiteStyleSettingsUpdate')->name('backend.admin.settings.website.style.settings.update');
                Route::post('update-custom-css', 'websiteCustomCssUpdate')->name('backend.admin.settings.website.custom.css.update');
                Route::post('update-notification-settings', 'websiteNotificationSettingsUpdate')->name('backend.admin.settings.website.notification.settings.update');
                Route::post('update-website-status', 'websiteStatusUpdate')->name('backend.admin.settings.website.status.update');
            });
        });
      
    });

});

// ====================== /BACKEND ======================

Route::get('clear-all', function () {
    Artisan::call('optimize:clear');
    return redirect()->back();
});

Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return redirect()->back();
});

Route::get('test', [TestController::class, 'test'])->name('test');
