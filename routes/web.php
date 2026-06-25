<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookCatalogController;

use App\Http\Controllers\Admin\DashboardController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);
    
    Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [BookCatalogController::class, 'home'])->name('user.home');
    Route::get('/library', [BookCatalogController::class, 'library'])->name('user.library');
    Route::get('/books/{book}', [BookCatalogController::class, 'show'])->name('books.show');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::post('/borrow', [BookCatalogController::class, 'borrow'])->name('user.borrow');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/books', [BookCatalogController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookCatalogController::class, 'create'])->name('books.create');
    Route::post('/books', [BookCatalogController::class, 'store'])->name('books.store');
    Route::put('/books/{id}', [BookCatalogController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookCatalogController::class, 'delete'])->name('books.delete');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::get('/requests', [UserController::class, 'requestsIndex'])->name('requests.index');
    Route::put('/requests/{id}', [UserController::class, 'updateStatus'])->name('requests.update');
});


