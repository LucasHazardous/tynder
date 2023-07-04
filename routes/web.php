<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\RelationController;
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
})->name("welcome");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [RelationController::class, 'recommend'])->name('dashboard');
    Route::post("/relation", [RelationController::class, 'createRelation'])->name('createRelation');

    Route::get('/chat', [MessageController::class, "getConnectedUsers"])->name('chat');
    Route::get('/chat/{connectedUserId}', [MessageController::class, "getMessagesWith"])->name('chat.messages');
    Route::post('/chat', [MessageController::class, "sendMessage"])->name('chat.message.send');
});

require __DIR__.'/auth.php';
