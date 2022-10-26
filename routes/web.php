<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SearchTaskController;

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

//gruplama ile dil seçenekleri açık ise urlye eklenir
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::get('/', function () {
            return view('welcome');
        });
        
        Route::get('/home', [TaskController::class, 'index'])->name('home_index');
        Route::post('/home/store', [TaskController::class, 'store'])->name('home_store');
        Route::post('/home/getTasks', [TaskController::class, 'getTasks'])->name('home_getTasks');
        Route::post('/home/destroy', [TaskController::class, 'destroy'])->name('home_destroy');
        Route::post('/home/update', [TaskController::class, 'update'])->name('home_update');
        Route::post('/home/search', [SearchTaskController::class, 'search'])->name('result_search');
});
