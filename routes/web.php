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
Route::get('/', function () {
    return redirect()->route('clocks');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/events', [App\Http\Controllers\Events\EventController::class, 'index'])->name('events');
Route::get('/events/create', [App\Http\Controllers\Events\EventController::class, 'create'])->name('events.create');
Route::any('/events/search', [App\Http\Controllers\Events\EventController::class, 'search'])->name('events.search');
Route::post('/events/store', [App\Http\Controllers\Events\EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}/edit', [App\Http\Controllers\Events\EventController::class, 'edit'])->name('events.edit');
Route::get('/events/{event}', [App\Http\Controllers\Events\EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/print-id', [App\Http\Controllers\Events\EventController::class, 'printid'])->name('events.show.print-id');
Route::get('/events/{event}/print-appearance', [App\Http\Controllers\Events\EventController::class, 'printappearance'])->name('events.show.print-appearance');
Route::get('/events/{event}/print-attendance', [App\Http\Controllers\Events\EventController::class, 'printattendance'])->name('events.show.print-attendance');
Route::get('/clocks/{event}/monitor', [App\Http\Controllers\Events\EventController::class, 'monitor'])->name('events.show.monitor');
Route::any('/clocks/{event}/monitor/search', [App\Http\Controllers\Events\EventController::class, 'searchmonitor'])->name('events.show.monitor-search');
Route::any('/events/{event}/search', [App\Http\Controllers\Events\EventController::class, 'searchshow'])->name('events.show.search');
Route::patch('/events/{event}', [App\Http\Controllers\Events\EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [App\Http\Controllers\Events\EventController::class, 'destroy'])->name('events.destroy');

Route::get('/regs', [App\Http\Controllers\Registrations\RegistrationController::class, 'index'])->name('registrations');
Route::get('/regs/create', [App\Http\Controllers\Registrations\RegistrationController::class, 'create'])->name('registrations.create');
Route::any('/regs/search', [App\Http\Controllers\Registrations\RegistrationController::class, 'search'])->name('registrations.search');
Route::post('/regs/store', [App\Http\Controllers\Registrations\RegistrationController::class, 'store'])->name('registrations.store');
Route::get('/regs/{registration}/edit', [App\Http\Controllers\Registrations\RegistrationController::class, 'edit'])->name('registrations.edit');
Route::get('/regs/{registration}/{type}', [App\Http\Controllers\Registrations\RegistrationController::class, 'confirm'])->name('registrations.confirm');
Route::get('/regs/{registration}', [App\Http\Controllers\Registrations\RegistrationController::class, 'show'])->name('registrations.show');
Route::patch('/regs/{registration}', [App\Http\Controllers\Registrations\RegistrationController::class, 'update'])->name('registrations.update');
Route::delete('/regs/{registration}', [App\Http\Controllers\Registrations\RegistrationController::class, 'destroy'])->name('registrations.destroy');

Route::get('/users', [App\Http\Controllers\Users\UserController::class, 'index'])->name('users');
Route::get('/users/{user}', [App\Http\Controllers\Users\UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [App\Http\Controllers\Users\UserController::class, 'destroy'])->name('users.destroy');

Route::get('/clocks/{event}/{type}', [App\Http\Controllers\ClockController::class, 'show'])->name('clocks.show');
Route::post('/clocks/{event}/{type}', [App\Http\Controllers\ClockController::class, 'clock'])->name('clocks.show.clock');
Route::get('/clocks', [App\Http\Controllers\ClockController::class, 'index'])->name('clocks');

