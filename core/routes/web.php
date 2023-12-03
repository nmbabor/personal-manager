<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DepositController;
use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\Backend\WebsiteSettingController;

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
// homepage
//Route::get('/','Frontend\HomeController@index')->name('frontend.home');
Route::get('/blogs','Frontend\HomeController@blogs')->name('frontend.blogs');
Route::get('/blogs/{category}','Frontend\HomeController@blogCategory')->name('frontend.blogs.category');
Route::get('/blog/{slug}','Frontend\HomeController@singleBlog')->name('frontend.blog.show');
Route::get('/pages/{slug}','Frontend\HomeController@singlePage')->name('frontend.page');

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

// ====================== /FRONTEND =====================

Route::get('dashboard', [AuthController::class, 'userDash'])->name('dashboard.redirect');
Route::get('user/auth-check', [AuthController::class, 'userAuthCheck'])->name('user.auth.check');

// ====================== BACKEND =======================

// admin
Route::prefix('user')->middleware(['auth'])->group(function () {
    //Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
    //profile
    Route::get('profile', [DashboardController::class, 'profile'])->name('user.profile');
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('user.update.profile');
});

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('backend.admin.dashboard');

    Route::resource('text-slider','Backend\TextSliderController');
    Route::resource('projects','Backend\ProjectController');
    Route::post('project-collection','Backend\ProjectController@paymentStore')->name('projects.collection');
    Route::put('project-collection/{id}','Backend\ProjectController@paymentUpdate')->name('projects.collection.update');
    Route::delete('project-collection/{id}','Backend\ProjectController@paymentDelete')->name('projects.collection.delete');

    Route::post('project-expense','Backend\ProjectController@expenseStore')->name('projects.expense');
    Route::put('project-expense/{id}','Backend\ProjectController@expenseUpdate')->name('projects.expense.update');
    Route::delete('project-expense/{id}','Backend\ProjectController@expenseDelete')->name('projects.expense.delete');
    // page builder
    Route::resource('page-builder','Backend\PageController');
    Route::resource('manage-notice','Backend\NoticeController');

    // Reports
    Route::prefix('reports')->group(function () {
        Route::get('due','Backend\ReportsController@due')->name('reports.due');
        Route::get('projects','Backend\ReportsController@projects')->name('reports.projects');
        Route::get('monthly-collection','Backend\ReportsController@monthlyCollection')->name('reports.monthly-collection');
        Route::get('income-expense','Backend\ReportsController@incomeExpense')->name('reports.income-expense');
        Route::post('close-year','Backend\ReportsController@closeYear')->name('reports.close-year');
    });
     // Deposit
    Route::prefix('deposit')->group(function () {
        Route::get('user-details/{id}',[DepositController::class, 'show'])->name('deposit.user-details');
        Route::post('monthly',[DepositController::class, 'monthlyDeposit'])->name('deposit.monthly');
        Route::put('monthly/{id}',[DepositController::class, 'monthlyDepositUpdate'])->name('deposit.monthly.update');
        Route::delete('monthly-delete/{id}', [DepositController::class, 'destroy'])->name('deposit.monthly.delete');
    });
    // users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('backend.admin.users');
        Route::get('suspend/{id}/{status}', [UserManagementController::class, 'suspend'])->name('backend.admin.user.suspend');
        Route::match(['get', 'post'], 'create', [UserManagementController::class, 'create'])->name('backend.admin.user.create');
        Route::match(['get', 'post'], 'edit/{id}', [UserManagementController::class, 'edit'])->name('backend.admin.user.edit');
        Route::get('delete/{id}', [UserManagementController::class, 'delete'])->name('backend.admin.user.delete');
    });


    // blogs
    Route::prefix('blogs')->group(function () {
        // blog category
        Route::resource('categories','Backend\BlogCategoryController');

        Route::get('/', [BlogController::class, 'index'])->name('backend.admin.blogs');
        Route::match(['get', 'post'], 'create', [BlogController::class, 'createBlog'])->name('backend.admin.blogs.create');
        Route::match(['get', 'post'], 'edit/{id}', [BlogController::class, 'editBlog'])->name('backend.admin.blogs.edit');
        Route::get('delete/{id}', [BlogController::class, 'deleteBlog'])->name('backend.admin.blogs.delete');
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
        Route::resource('menus','Backend\MenuController');
        Route::put('menu-serial-update','Backend\MenuController@serialUpdate')->name('menu-serial-update');

        Route::post('sub-menus','Backend\SubMenuController@store')->name('sub-menus.store');
        Route::match(['put','patch'],'sub-menus/{id}','Backend\SubMenuController@update')->name('sub-menus.update');
        Route::delete('sub-menus/{id}','Backend\SubMenuController@destroy')->name('sub-menus.destroy');
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
