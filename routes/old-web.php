<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduledPostController;
use App\Http\Controllers\SocialConnectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

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

// Profile Routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
