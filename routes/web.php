<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduledPostController;
use App\Http\Controllers\SocialConnectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile/social/{provider}', [ProfileController::class, 'disconnectSocialAccount'])
        ->name('profile.social.disconnect');
});

// Package Routes
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::post('/packages/upgrade', [PackageController::class, 'upgrade'])
    ->name('packages.upgrade')
    ->middleware('auth');

// Social Authentication Routes
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('social.redirect')
    ->middleware('auth');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('social.callback');

// Social Connect Routes
Route::get('/social/connect', [SocialConnectController::class, 'index'])
    ->name('social.connect')
    ->middleware('auth');

// Post Management Routes
Route::resource('posts', ScheduledPostController::class)
    ->middleware('auth');