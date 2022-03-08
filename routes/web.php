<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Auth::routes();

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/passwword/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.config');
Route::post('/password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.confirm');
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // USERS
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->middleware('permission:view-users')->name('users');
    Route::put('users/edit', [App\Http\Controllers\UserController::class, 'update'])->middleware('permission:edit-users')->name('users.edit');
    Route::get('users/new', [App\Http\Controllers\UserController::class, 'new'])->middleware('permission:create-users')->name('users.new');
    Route::post('users/new', [App\Http\Controllers\UserController::class, 'create'])->middleware('permission:create-users')->name('users.create');
    // ROLES
    Route::get('roles', [App\Http\Controllers\RoleController::class, 'index'])->middleware('permission:view-roles')->name('roles');
    Route::get('roles/new', [App\Http\Controllers\RoleController::class, 'new'])->middleware('permission:create-roles')->name('roles.new');
    Route::post('roles/new', [App\Http\Controllers\RoleController::class, 'create'])->middleware('permission:create-roles')->name('roles.create');
    Route::get('roles/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->middleware('permission:edit-roles')->name('roles.edit');
    Route::put('roles/edit/{id}', [App\Http\Controllers\RoleController::class, 'update'])->middleware('permission:edit-roles')->name('roles.update');
    Route::delete('roles/{id}', [App\Http\Controllers\RoleController::class, 'delete'])->middleware('permission:edit-roles')->name('roles.delete');
    // UPLOAD
    Route::get('bulk', [App\Http\Controllers\UploadController::class, 'index'])->name('uploads');
    Route::post('bulk/tasks', [App\Http\Controllers\UploadController::class, 'pushTasks'])->name('uploads.tasks');
    Route::post('bulk/agents', [App\Http\Controllers\UploadController::class, 'pushAgents'])->name('uploads.agents');
    Route::post('bulk/stores', [App\Http\Controllers\UploadController::class, 'pushStores'])->name('uploads.stores');
    Route::post('bulk/clients', [App\Http\Controllers\UploadController::class, 'pushClients'])->name('uploads.clients');
    // CLIENT
    Route::get('clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients');
    Route::get('clients/new', [App\Http\Controllers\ClientController::class, 'new'])->name('clients.new');
    Route::post('clients/new', [App\Http\Controllers\ClientController::class, 'create'])->name('clients.create');
    Route::get('clients/edit/{id}', [App\Http\Controllers\ClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/edit/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('clients.update');
    // STORE
    Route::get('stores', [App\Http\Controllers\StoreController::class, 'index'])->name('stores');
    Route::get('stores/new', [App\Http\Controllers\StoreController::class, 'new'])->name('stores.new');
    Route::post('stores/new', [App\Http\Controllers\StoreController::class, 'create'])->name('stores.create');
    Route::get('stores/edit/{id}', [App\Http\Controllers\StoreController::class, 'edit'])->name('stores.edit');
    Route::put('stores/edit/{id}', [App\Http\Controllers\StoreController::class, 'update'])->name('stores.update');
    // AGENT
    Route::get('agents', [App\Http\Controllers\AgentController::class, 'index'])->name('agents');
    Route::post('agents/new', [App\Http\Controllers\AgentController::class, 'create'])->name('agents.create');
    Route::put('agents/edit/{id}', [App\Http\Controllers\AgentController::class, 'update'])->name('agents.update');
    // TASK
    
    //INCIDENCE

});
