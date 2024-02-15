<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;

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
})->name('welcome');

// Modified to include email verification
Auth::routes(['verify' => true]);

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard')->middleware('verified');

Route::get('/domains', [DomainController::class, 'index'])->name('domains.index')->middleware(['auth', 'verified']);
Route::post('/domains/assign', [DomainController::class, 'assign'])->name('domains.assign')->middleware(['auth', 'verified', 'can:assign-domains']);

Route::post('/organizations/assign', [DomainController::class, 'assignOrganization'])->name('organizations.assign')->middleware(['auth', 'verified', 'can:assign-organizations']);

Route::middleware(['can:is-orgadmin', 'verified'])->group(function () {
    // Add routes that require the user to be an org admin and have a verified email here
});

Route::get('/manage', [App\Http\Controllers\ManageController::class, 'index'])
     ->middleware(['auth', 'verified', 'can:access-manage-page'])->name('manage');

Route::get('/monitoring/{domain}', [App\Http\Controllers\MonitoringController::class, 'show'])
     ->middleware(['auth', 'verified', 'can:view-monitoring,domain'])
     ->name('monitoring.show');


Route::get('/settings', function () {
    return view('settings');
})->name('settings')->middleware(['auth', 'verified']);

Route::get('language/{lang}', [App\Http\Controllers\LanguageController::class, 'switchLang'])
     ->name('language.switch');

Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')
     ->name('password.request');

Route::post('/remove-user-from-domain', [DomainController::class, 'removeUserFromDomain'])->middleware(['auth', 'verified', 'can:assign-domains']);
Route::post('/remove-user-from-organization', [DomainController::class, 'removeUserFromOrganization'])
     ->middleware(['auth', 'verified', 'can:remove-user-organization']);

Route::delete('/user/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete')->middleware(['auth', 'verified']);

Route::get('/api/organizations/{organization}/domains', [DomainController::class, 'getOrganizationDomains'])->middleware(['auth', 'verified']);

Route::post('/manage/remove-user-from-domain', [App\Http\Controllers\ManageController::class, 'removeUserFromDomain'])
     ->middleware(['auth', 'verified', 'can:remove-user-domain']);

Route::post('/manage/add-user-to-domain', [App\Http\Controllers\ManageController::class, 'addUserToDomain'])
     ->middleware(['auth', 'verified', 'can:add-user-domain'])->name('add-user-to-domain');
