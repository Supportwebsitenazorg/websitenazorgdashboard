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
Route::post('/domeinen/assign', [DomainController::class, 'assign'])->name('domains.assign')->middleware('auth', 'can:assign-domains');

Route::post('/organizations/assign', [DomainController::class, 'assignOrganization'])->name('organizations.assign')->middleware('auth', 'can:assign-organizations');

Route::middleware(['can:is-orgadmin'])->group(function () {
    // moet nog worden ingevuld
});

Route::get('/monitoring/{domain}', [App\Http\Controllers\MonitoringController::class, 'show'])
     ->name('monitoring.show')->middleware('auth');

Route::get('/settings', function () {
    return view('settings');
})->name('settings')->middleware('auth');

Route::get('language/{lang}', [App\Http\Controllers\LanguageController::class, 'switchLang'])
     ->name('language.switch');

Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')
     ->name('password.request');

Route::post('/remove-user-from-domain', [DomainController::class, 'removeUserFromDomain'])->middleware('auth', 'can:assign-domains');
Route::post('/remove-user-from-organization', [DomainController::class, 'removeUserFromOrganization'])->middleware('auth', 'can:assign-organizations');

Route::delete('/user/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete')->middleware('auth');

Route::get('/api/organizations/{organization}/domains', [DomainController::class, 'getOrganizationDomains'])->middleware('auth');

