<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', \App\Http\Livewire\Home::class );
Route::get('/logs', \App\Http\Livewire\Logs::class )->name('logs');
Route::get('/settings', \App\Http\Livewire\SettingsComponent::class)->name('settings');
Route::get('/log-time/{time}', \App\Http\Livewire\LogTimeComponent::class)->name('log-time');
Route::get('/edit-time-entry/{time}', \App\Http\Livewire\EditTimeEntryComponent::class)->name('edit-time-entry');
Route::get('/auto-import', \App\Http\Livewire\AutoImport::class)->name('auto-import');
