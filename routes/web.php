<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/domeinen', [DomainController::class, 'index'])->name('domains.index')->middleware('auth');
Route::post('/domeinen/toevoegen', [DomainController::class, 'add'])->name('domains.add')->middleware('auth');
Route::post('/domeinen/assign', [DomainController::class, 'assign'])->name('domains.assign')->middleware('auth', 'can:assign-domains');

Route::get('/settings', function () {
    return view('settings');
})->name('settings')->middleware('auth');


