<?php

use App\Livewire\Portal\Dashboard;
use App\Livewire\Portal\Login;
use App\Livewire\Portal\NewInquiry;
use App\Livewire\Portal\QuoteDetail;
use App\Livewire\Portal\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/portal/login'));

// Guest-only portal routes
Route::middleware('guest')->prefix('portal')->group(function () {
    Route::get('/login',    Login::class)->name('portal.login');
    Route::get('/register', Register::class)->name('portal.register');
});

// Auth-required portal routes
Route::middleware('auth')->prefix('portal')->group(function () {
    Route::get('/dashboard',                  Dashboard::class)->name('portal.dashboard');
    Route::get('/inquiries/new',              NewInquiry::class)->name('portal.inquiries.new');
    Route::get('/inquiries/{inquiry}/quote',  QuoteDetail::class)->name('portal.quote');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/portal/login');
    })->name('portal.logout');
});
