<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\ReportController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->middleware('admin')->withoutMiddleware('admin.guest')->name('logout');
    });
});

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::post('notification/delete/{id}', 'notificationDelete')->name('notification.delete');
    });

    Route::controller(ManageUsersController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('activated', 'activatedUsers')->name('activated');
        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('login/{id}', 'login')->name('login');
        Route::post('toggle-status/{id}', 'toggleStatus')->name('toggle.status');
        Route::post('reset-daily-claim/{id}', 'resetDailyClaim')->name('reset.daily.claim');
    });

    Route::controller(CategoryController::class)->prefix('categories')->name('category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::post('toggle-status/{id}', 'toggleStatus')->name('toggle.status');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

        Route::controller(TaskController::class)->prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('pending', 'pending')->name('pending');
        Route::get('active', 'active')->name('active');
        Route::get('completed', 'completed')->name('completed');
        Route::get('create', 'create')->name('create');
        Route::match(['get', 'post', 'put'], 'store/{id?}', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('toggle-status/{id}', 'toggleStatus')->name('toggle.status');
        Route::post('delete/{id}', 'delete')->name('delete');
        Route::get('submissions', 'submissions')->name('submissions');
        Route::get('submissions/pending', 'pendingSubmissions')->name('submissions.pending');
        Route::post('submissions/approve/{id}', 'approveSubmission')->name('submissions.approve');
        Route::post('submissions/reject/{id}', 'rejectSubmission')->name('submissions.reject');
    });

    Route::controller(DepositController::class)->prefix('deposits')->name('deposits.')->group(function () {
        Route::get('/', 'all')->name('all');
        Route::get('pending', 'pending')->name('pending');
        Route::get('approved', 'approved')->name('approved');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('activation', 'activation')->name('activation');
        Route::post('activation/approve/{id}', 'activationApprove')->name('activation.approve');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('approve/{id}', 'approve')->name('approve');
        Route::post('reject', 'reject')->name('reject');
        Route::get('methods', 'methods')->name('methods');
        Route::post('methods/store/{id?}', 'methodStore')->name('methods.store');
        Route::post('methods/toggle-status/{id}', 'methodToggleStatus')->name('methods.toggle.status');
        Route::post('methods/delete/{id}', 'methodDelete')->name('methods.delete');
    });

    Route::controller(WithdrawalController::class)->prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', 'all')->name('all');
        Route::get('pending', 'pending')->name('pending');
        Route::get('approved', 'approved')->name('approved');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('approve', 'approve')->name('approve');
        Route::post('reject', 'reject')->name('reject');
        Route::get('methods', 'methods')->name('methods');
        Route::post('methods/store/{id?}', 'methodStore')->name('methods.store');
        Route::post('methods/toggle-status/{id}', 'toggleMethodStatus')->name('methods.toggle.status');
        Route::post('methods/delete/{id}', 'methodDelete')->name('methods.delete');
    });

    Route::controller(SupportTicketController::class)->prefix('tickets')->name('ticket.')->group(function () {
        Route::get('/', 'tickets')->name('index');
        Route::get('pending', 'pending')->name('pending');
        Route::get('closed', 'closed')->name('closed');
        Route::get('view/{id}', 'view')->name('view');
        Route::post('reply/{id}', 'reply')->name('reply');
        Route::post('close/{id}', 'close')->name('close');
    });

    Route::controller(GeneralSettingController::class)->group(function () {
        Route::get('general-setting', 'general')->name('setting.general');
        Route::post('general-setting', 'generalUpdate');
        Route::get('system-setting', 'system')->name('setting.system');
        Route::post('system-setting', 'systemUpdate');
        Route::get('logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('logo-icon', 'logoIconUpdate');
        Route::get('smtp-settings', 'smtp')->name('setting.smtp');
        Route::post('smtp-settings', 'smtpUpdate')->name('setting.smtp.update');
        Route::post('smtp-test', 'smtpTest')->name('setting.smtp.test');
        Route::get('frontend-sections/{key?}', 'frontendSections')->name('frontend.sections');
        Route::post('frontend-content/{key}', 'frontendContent')->name('frontend.content');
        Route::get('pages/about', function() { 
            $pageTitle = 'About Us';
            $sections = getContent('about_us');
            return view('admin.frontend.index', compact('pageTitle', 'sections'));
        })->name('pages.about');
        Route::get('pages/contact', function() {
            $pageTitle = 'Contact Us';
            $sections = getContent('contact_us');
            return view('admin.frontend.index', compact('pageTitle', 'sections'));
        })->name('pages.contact');
        Route::get('pages/support', function() {
            $pageTitle = 'Support';
            $sections = getContent('support');
            return view('admin.frontend.index', compact('pageTitle', 'sections'));
        })->name('pages.support');
        Route::get('pages/terms', function() {
            $pageTitle = 'Terms & Conditions';
            $sections = getContent('terms_conditions');
            return view('admin.frontend.index', compact('pageTitle', 'sections'));
        })->name('pages.terms');
        Route::get('pages/privacy', function() {
            $pageTitle = 'Privacy Policy';
            $sections = getContent('privacy_policy');
            return view('admin.frontend.index', compact('pageTitle', 'sections'));
        })->name('pages.privacy');
    });

    Route::controller(ReportController::class)->prefix('reports')->name('reports.')->group(function () {
        Route::get('transactions', 'transaction')->name('transaction');
        Route::get('logins', 'loginHistory')->name('login.history');
        Route::get('notifications', 'notificationHistory')->name('notification.history');
    });
});
