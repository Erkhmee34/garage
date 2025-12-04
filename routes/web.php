<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;

Route::get('/', function () {
    return redirect()->route('ads.index');
});

Route::get('/dashboard', function () {
    $ads = App\Models\Ad::latest()->paginate(12);
    return view('dashboard', compact('ads'));
})->middleware(['auth', 'verified'])->name('dashboard');

// БҮХ ЗАРУУДЫН ROUTE-УУД (нэвтэрсэн эсвэл нэвтрээгүй хүн бүр хэрэглэнэ)
Route::get('/ads', [AdController::class, 'index'])->name('ads.index');

// ЗӨВХӨН НЭВТЭРСЭН ХЭРЭГЛЭГЧИД (auth middleware)
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Зар оруулах, засах, устгах
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
    Route::get('/my-ads', [AdController::class, 'myAds'])->name('my.ads');

    // LIKE BUTTON – ЯГ ЭНД БАЙХ ЁСТОЙ!
    Route::post('/ads/{ad}/like', [AdController::class, 'like'])->name('ads.like');
});

// Зарын дэлгэрэнгүй (нэвтэрсэн эсвэл нэвтрээгүй хүн бүр)
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');

require __DIR__.'/auth.php';