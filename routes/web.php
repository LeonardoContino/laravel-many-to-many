<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\Homecontroller as GuestHomeController;
use App\Http\Controllers\Admin\Homecontroller as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;

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

Route::get('/', [GuestHomecontroller::class, 'index']);

Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {

 Route::get('/',[AdminHomeController::class, 'index'])->name('home');

 //rotte project

 Route::resource('/projects', ProjectController::class);
 


});

Route::middleware('auth')->name('profile.')->prefix('/profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';

Route::resource('admin/technologies', App\Http\Controllers\Admin\TechnologyController::class, ['as' => 'admin']);