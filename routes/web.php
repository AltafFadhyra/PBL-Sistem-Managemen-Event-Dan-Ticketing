<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
Route::get('/events/{slug}', [\App\Http\Controllers\Frontend\EventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [\App\Http\Controllers\Frontend\RegistrationController::class, 'store'])->name('events.register');
Route::get('/checkout/{registration:registration_number}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{registration:registration_number}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'store'])->name('checkout.store');
Route::delete('/checkout/{registration:registration_number}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'destroy'])->name('checkout.destroy');
Route::get('/registrations/{registration:registration_number}', [\App\Http\Controllers\Frontend\RegistrationController::class, 'show'])->name('registrations.show');

// Cek Tiket Public
Route::get('/cek-tiket', [\App\Http\Controllers\Frontend\TicketSearchController::class, 'index'])->name('tickets.search');
Route::post('/cek-tiket', [\App\Http\Controllers\Frontend\TicketSearchController::class, 'find'])->name('tickets.find');

// Redirect public /register attempt
Route::get('/register', function () {
    if (auth()->check() && auth()->user()->role === 'superadmin') {
        return redirect()->route('admin.users.create');
    }
    return redirect()->route('login')->with('error', 'Pendaftaran mandiri ditutup. Hubungi SuperAdmin.');
})->name('register');

Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Rute untuk Admin Biasa & Superadmin
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::delete('posters/{poster}', [\App\Http\Controllers\Admin\EventController::class, 'destroyPoster'])->name('posters.destroy');
    Route::resource('events.tickets', \App\Http\Controllers\Admin\TicketTypeController::class)->shallow();
    Route::get('events/{event}/registrations', [\App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('events.registrations');
    Route::patch('registrations/{registration}/approve', [\App\Http\Controllers\Admin\RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::patch('registrations/{registration}/reject', [\App\Http\Controllers\Admin\RegistrationController::class, 'reject'])->name('registrations.reject');

    // Rute KHUSUS Superadmin
    Route::middleware([\App\Http\Middleware\IsSuperadmin::class])->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\EventCategoryController::class)->except(['show']);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show', 'edit', 'update']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
