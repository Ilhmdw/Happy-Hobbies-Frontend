<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── AUTH ──────────────────────────────────────────────────────────
Route::get('/login',    fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.login'))->name('register');

// POST login — simpan demo user ke session (frontend testing)
Route::post('/login', function (Request $req) {
    session(['demo_user' => [
        'name'  => 'Ilham Dwitarama',
        'email' => $req->input('email', 'mieindo340@gmail.com'),
        'role'  => 'customer',
    ]]);
    return redirect('/');
});

// POST register — sama, simpan ke session lalu redirect
Route::post('/register', function (Request $req) {
    $firstName = $req->input('first_name', 'User');
    $lastName  = $req->input('last_name', 'Baru');
    session(['demo_user' => [
        'name'  => trim($firstName . ' ' . $lastName),
        'email' => $req->input('email', 'user@happyhobbies.id'),
        'role'  => 'customer',
    ]]);
    return redirect('/');
});

// POST logout — hapus session
Route::post('/logout', function () {
    session()->forget('demo_user');
    return redirect('/');
})->name('logout');

// ── CUSTOMER ─────────────────────────────────────────────────────
Route::get('/', fn() => view('customer.home'))->name('home');

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/',       fn() => view('customer.products.index'))->name('index');
    Route::get('/{slug}', fn() => view('customer.products.show'))->name('show');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', fn() => view('customer.checkout.index'))->name('index');
});

Route::prefix('account')->name('account.')->group(function () {
    Route::get('/',          fn() => view('customer.account.index'))->name('index');
    Route::get('/orders',    fn() => view('customer.account.orders'))->name('orders');
    Route::get('/addresses', fn() => view('customer.account.addresses'))->name('addresses');
    Route::get('/password',  fn() => view('customer.account.password'))->name('password');
});

// ── ADMIN ─────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                   fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/products',           fn() => view('admin.products.index'))->name('products.index');
    Route::get('/products/create',    fn() => view('admin.products.create'))->name('products.create');
    Route::get('/products/{id}/edit', fn() => view('admin.products.edit'))->name('products.edit');
    Route::get('/orders',             fn() => view('admin.orders.index'))->name('orders.index');
    Route::get('/categories',         fn() => view('admin.categories'))->name('categories');
    Route::get('/pic',                fn() => view('admin.pic'))->name('pic');
    Route::get('/settings',           fn() => view('admin.settings'))->name('settings');
});
