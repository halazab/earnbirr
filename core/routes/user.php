<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\WithdrawController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\DailyClaimController;
use App\Http\Controllers\User\KycController;
use App\Http\Controllers\User\ReferralController;

Route::name('user.')->middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::match(['get', 'post'], 'logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'showRegistrationForm')->name('register');
        Route::post('/register', 'register');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
    });

    Route::controller(ForgotPasswordController::class)->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller(VerificationController::class)->prefix('email')->name('verification.')->group(function () {
        Route::get('verify', 'showVerificationForm')->name('form');
        Route::post('send', 'sendVerificationEmail')->name('send');
        Route::post('verify', 'verify')->name('verify');
    });
});

Route::middleware('auth')->name('user.')->group(function () {

    Route::controller(DepositController::class)->group(function () {
        Route::get('/activation', 'activationFee')->name('activation');
        Route::post('/activation', 'activationFeeSubmit');
    });

    Route::middleware('check.status')->group(function () {

        Route::controller(UserController::class)->group(function () {
            Route::get('/dashboard', 'home')->name('home');
            Route::get('/transactions', 'transactions')->name('transactions');
            Route::get('/deposit/history', 'depositHistory')->name('deposit.history');
            Route::get('/download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile-setting', 'profile')->name('profile.setting');
            Route::post('/profile-setting', 'submitProfile');
            Route::get('/change-password', 'changePassword')->name('change.password');
            Route::post('/change-password', 'submitPassword');
        });

        Route::controller(TaskController::class)->prefix('tasks')->name('tasks.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('my', 'myTasks')->name('my');
            Route::get('{slug}', 'details')->name('details');
            Route::post('submit/{id}', 'submit')->name('submit');
        });

        Route::get('/kyc', [KycController::class, 'index'])->name('kyc');
        Route::post('/kyc', [KycController::class, 'submit'])->name('kyc.submit');

        Route::post('/daily-claim', [DailyClaimController::class, 'claim'])->name('daily.claim');

        Route::controller(DepositController::class)->prefix('deposit')->name('deposit.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/insert', 'insert')->name('insert');
        });

        Route::middleware('kyc')->controller(WithdrawController::class)->prefix('withdraw')->name('withdraw.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/history', 'history')->name('history');
        });

        Route::controller(TicketController::class)->prefix('ticket')->name('ticket.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('new', 'create')->name('create');
            Route::post('create', 'store')->name('store');
            Route::get('view/{id}', 'view')->name('view');
            Route::post('reply/{id}', 'reply')->name('reply');
            Route::post('close/{id}', 'close')->name('close');
        });

        Route::controller(ReferralController::class)->prefix('referral')->name('referral.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/add', 'store')->name('store');
        });
    });
});
