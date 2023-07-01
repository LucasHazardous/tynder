<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'recommend'])->name('dashboard');
    Route::post("/relation", [DashboardController::class, 'createRelation'])->name('createRelation');

    Route::get('/chat', [ChatController::class, "getConnectedUsers"])->name('chat');
    Route::get('/chat/{connectedUserId}', [ChatController::class, "getMessagesWith"])->name('chat.messages');
    Route::post('/chat', [ChatController::class, "sendMessage"])->name('chat.message.send');
});

require __DIR__.'/auth.php';
