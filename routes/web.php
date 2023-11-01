<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;

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


Route::get('/admin/', [AdminTopController::class, 'top'])->name('admin.top');

Route::get('/admin/news/add', [AdminNewsController::class, 'add'])->name('admin.news.add');
Route::post('/admin/news/insert', [AdminNewsController::class, 'insert'])->name('admin.news.insert');
Route::get('/admin/news/list', [AdminNewsController::class, 'list'])->name('admin.news.list');
Route::get('/admin/news/{id}', [AdminNewsController::class, 'detail'])->name('admin.news.detail');
Route::get('/admin/news/edit/{id}', [AdminNewsController::class, 'edit'])->name('admin.news.edit');