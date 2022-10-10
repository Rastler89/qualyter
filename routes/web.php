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
Route::get('/', function(){
    return redirect('/login');
});

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
    // AUDTION
    Route::get('audit', [App\Http\Controllers\AuditionController::class, 'viewAudit'])->name('audition');
    // LOG
    Route::get('log', [App\Http\Controllers\AuditionController::class, 'viewLog'])->name('log');
    // PROFILE
    Route::get('profile', [App\Http\Controllers\UserController::class, 'getProfile'])->name('profile');
    Route::post('profile/name', [App\Http\Controllers\UserController::class, 'saveName'])->name('profile.name');
    Route::post('profile/password', [App\Http\Controllers\UserController::class, 'savePassword'])->name('profile.password');
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
    Route::get('bulk', [App\Http\Controllers\UploadController::class, 'index'])->middleware('permission:view-bulks')->name('uploads');
    Route::post('bulk/tasks', [App\Http\Controllers\UploadController::class, 'pushTasks'])->middleware('permission:bulk-talks')->name('uploads.tasks');
    Route::post('bulk/agents', [App\Http\Controllers\UploadController::class, 'pushAgents'])->middleware('permission:bulk-agents')->name('uploads.agents');
    Route::post('bulk/stores', [App\Http\Controllers\UploadController::class, 'pushStores'])->middleware('permission:bulk-stores')->name('uploads.stores');
    Route::post('bulk/clients', [App\Http\Controllers\UploadController::class, 'pushClients'])->middleware('permission:bulk-clients')->name('uploads.clients');
    // CLIENT
    Route::get('clients', [App\Http\Controllers\ClientController::class, 'index'])->middleware('permission:view-clients')->name('clients');
    Route::get('clients/new', [App\Http\Controllers\ClientController::class, 'new'])->middleware('permission:add-clients')->name('clients.new');
    Route::post('clients/new', [App\Http\Controllers\ClientController::class, 'create'])->middleware('permission:add-clients')->name('clients.create');
    Route::get('clients/edit/{id}', [App\Http\Controllers\ClientController::class, 'edit'])->middleware('permission:edit-clients')->name('clients.edit');
    Route::put('clients/edit/{id}', [App\Http\Controllers\ClientController::class, 'update'])->middleware('permission:edit-clients')->name('clients.update');
    Route::get('clients/send/{id}', [App\Http\Controllers\ClientController::class, 'send'])->middleware('permission:view-clients')->name('clients.send');
    Route::get('clients/download/{id}', [App\Http\Controllers\ClientController::class, 'download'])->middleware('permission:view-clients')->name('clients.download');
    // STORE
    Route::get('stores', [App\Http\Controllers\StoreController::class, 'index'])->middleware('permission:view-stores')->name('stores');
    Route::get('stores/new', [App\Http\Controllers\StoreController::class, 'new'])->middleware('permission:add-stores')->name('stores.new');
    Route::post('stores/new', [App\Http\Controllers\StoreController::class, 'create'])->middleware('permission:add-stores')->name('stores.create');
    Route::get('stores/edit/{id}', [App\Http\Controllers\StoreController::class, 'edit'])->middleware('permission:edit-stores')->name('stores.edit');
    Route::put('stores/edit/{id}', [App\Http\Controllers\StoreController::class, 'update'])->middleware('permission:edit-stores')->name('stores.update');
    // AGENT
    Route::get('agents', [App\Http\Controllers\AgentController::class, 'index'])->middleware('permission:view-agents')->name('agents');
    Route::post('agents/new', [App\Http\Controllers\AgentController::class, 'create'])->middleware('permission:add-agents')->name('agents.create');
    Route::put('agents/edit/{id}', [App\Http\Controllers\AgentController::class, 'update'])->middleware('permission:edit-agents')->name('agents.update');
    // TASK
    Route::get('tasks', [App\Http\Controllers\AnswerController::class, 'index'])->middleware('permission:view-tasks')->name('tasks');
    Route::get('tasks/view/{id}', [App\Http\Controllers\AnswerController::class, 'view'])->middleware('permission:response-tasks')->name('tasks.view');
    Route::post('tasks/view/{id}', [App\Http\Controllers\AnswerController::class, 'response'])->middleware('permission:response-tasks')->name('tasks.response');
    Route::post('tasks/cancel/{id}', [App\Http\Controllers\AnswerController::class, 'cancel'])->middleware('permission:response-tasks')->name('tasks.cancel');
    Route::get('tasks/notrespond/{id}', [App\Http\Controllers\AnswerController::class, 'notrespond'])->middleware('permission:response-tasks')->name('tasks.notrespond');
    // ANSWER
    Route::get('answers', [App\Http\Controllers\AnswerController::class, 'answers'])->middleware('permission:view-tasks')->name('answers');
    Route::get('answers/{id}', [App\Http\Controllers\AnswerController::class, 'viewAnswer'])->middleware('permission:response-tasks')->name('answers.view');
    Route::post('answers/revised/{id}', [App\Http\Controllers\AnswerController::class, 'revised'])->middleware('permission:response-tasks')->name('answers.revised');
    Route::post('answers/complete/{id}',[App\Http\Controllers\AnswerController::class, 'complete'])->middleware('permission:response-tasks')->name('answers.complete');
    Route::get('answers/reactivate/{id}', [App\Http\Controllers\AnswerController::class, 'reactivate'])->middleware('permission:response-tasks')->name('answers.reactivate');
    Route::post('answers/send/{id}', [App\Http\Controllers\AnswerController::class, 'sendTechnician'])->name('answers.send');
    // WORK ORDER
    Route::get('workorder/new', [App\Http\Controllers\TaskController::class, 'new'])->name('workorder.new');
    Route::post('workorder/new', [App\Http\Controllers\TaskController::class, 'create'])->name('workorder.create');
    
    //INCIDENCE
    Route::get('incidences', [App\Http\Controllers\IncidenceController::class, 'index'])->middleware('permission:view-incidences')->name('incidences');
    Route::post('incidences', [App\Http\Controllers\IncidenceController::class, 'create'])->middleware('permission:change-incidences')->name('incidences.create');
    Route::get('incidences/{id}', [App\Http\Controllers\IncidenceController::class, 'view'])->middleware('permission:response-incidences')->name('incidences.view');
    Route::post('incidences/{id}/changeAgent', [App\Http\Controllers\IncidenceController::class, 'changeAgent'])->middleware('permission:change-incidences')->name('incidences.changeAgent');
    Route::post('incidences/{id}', [App\Http\Controllers\IncidenceController::class, 'modify'])->middleware('permission:response-incidences')->name('incidences.modify');
    Route::get('incidences/send/{id}', [App\Http\Controllers\IncidenceController::class, 'resend'])->name('incidences.resend');
    Route::post('incidences/{id}/complete', [App\Http\Controllers\IncidenceController::class, 'complete'])->middleware('permission:change-incidences')->name('incidences.complete');
    Route::post('incidences/{id}/wait', [App\Http\Controllers\IncidenceController::class, 'wait'])->middleware('permission:change-incidences')->name('incidences.wait');
    Route::post('incidences/{id}/process', [App\Http\Controllers\IncidenceController::class, 'process'])->middleware('permission:change-incidences')->name('incidences.process');

    //TEAM
    Route::get('teams',[App\Http\Controllers\TeamController::class, 'index'])->name('team.index');
    Route::post('teams/new',[App\Http\Controllers\TeamController::class, 'create'])->name('team.create');
    Route::put('teams/edit/{id}',[App\Http\Controllers\TeamController::class, 'update'])->name('team.update');

    // EXPORTS
    Route::get('export/answer', [App\Http\Controllers\ExportController::class, 'answer'])->name('export.answer');
    Route::post('export/answer', [App\Http\Controllers\ExportController::class, 'answer'])->name('export.answer');

    // REPORTS
    Route::get('reports/leaderboard', [App\Http\Controllers\ReportsController::class, 'leaderboardAgents'])->name('leaderboard');
    Route::get('reports/targets', [App\Http\Controllers\ReportsController::class, 'targets'])->name('reports.target');
    Route::get('reports/incidences', [App\Http\Controllers\ReportsController::class, 'incidences'])->name('reports.incidences');
    // CALL
    Route::get('answer/call/{id}', [App\Http\Controllers\AnswerController::class, 'call'])->name('call.answer');
    Route::get('incidence/call/{id}', [App\Http\Controllers\IncidenceController::class, 'call'])->name('call.incidence');

});
//Special
//Route::get('leaderboard',[App\Http\Controllers\ReportsController::class, 'leaderboard_animated']);
// INCIDENCE
Route::get('agent/', [App\Http\Controllers\IncidenceController::class, 'agent_login'])->name('incidences.agent_login');
Route::post('agent/', [App\Http\Controllers\IncidenceController::class, 'agent_session']);
Route::get('agent/dashboard', [App\Http\Controllers\IncidenceController::class, 'agent_dashboard'])->name('incidences.agent_dashboard');
Route::get('agent/incidence/{id}', [App\Http\Controllers\IncidenceController::class, 'response'])->name('incidences.agent');
Route::post('agent/incidence/{id}', [App\Http\Controllers\IncidenceController::class, 'update'])->name('incidences.update');
// STORE
Route::get('store/survey/{id}', [App\Http\Controllers\AnswerController::class, 'viewSurvey'])->name('answer.survey');
Route::post('store/survey/{id}', [App\Http\Controllers\AnswerController::class, 'responseSurvey'])->name('answer.response');
//PUBLIC STATS
Route::get('public/{id}', [App\Http\Controllers\PublicController::class,'index'])->name('public.index');
Route::get('public/{central}/detail/{delegation}', [App\Http\Controllers\PublicController::class, 'detail'])->name('public.detail');

Route::get('test',[App\Http\Controllers\TestController::class,'handle']);