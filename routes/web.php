<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\FirstCategoryController as AdminFirstCategorayController;
use App\Http\Controllers\Admin\SecondCategoryController as AdminSecondCategorayController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\TopController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;

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
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::middleware('auth.basic')->group(function(){

    Route::middleware(['guest'])->group(function () {

        Route::get('/admin/login', [AdminAuthController::class, 'show_login'])->name('admin.auth.show_login');
        Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.auth.login');
    
        Route::get('/', [TopController::class, 'top'])->name('top');
    
        Route::get('/news/list', [NewsController::class, 'list'])->name('news.list');
        Route::get('/news/{id}', [NewsController::class, 'detail'])->name('news.detail');
    
        Route::get('/product/list', [ProductController::class, 'list'])->name('product.list');
        Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
    
        Route::get('/contact/add', [ContactController::class, 'add'])->name('contact.add');
        Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
        Route::post('/contact/insert', [ContactController::class, 'insert'])->name('contact.insert');
        Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');
    
        Route::get('/terms_of_use', [TopController::class, 'terms_of_use'])->name('terms_of_use');
        Route::get('/privacy_policy', [TopController::class, 'privacy_policy'])->name('privacy_policy');
    });
    
    
    Route::middleware(['auth'])->group(function () {
    
        Route::get('/admin/', [AdminTopController::class, 'top'])->name('admin.top');
    
        Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.auth.logout');
    
        Route::get('/admin/news/add', [AdminNewsController::class, 'add'])->name('admin.news.add');
        Route::post('/admin/news/insert', [AdminNewsController::class, 'insert'])->name('admin.news.insert');
        Route::get('/admin/news/list', [AdminNewsController::class, 'list'])->name('admin.news.list');
        Route::get('/admin/news/{id}', [AdminNewsController::class, 'detail'])->name('admin.news.detail');
        Route::get('/admin/news/edit/{id}', [AdminNewsController::class, 'edit'])->name('admin.news.edit');
        Route::post('/admin/news/update', [AdminNewsController::class, 'update'])->name('admin.news.update');
        Route::post('/admin/news/delete', [AdminNewsController::class, 'delete'])->name('admin.news.delete');
    
        Route::get('/admin/first_category/add', [AdminFirstCategorayController::class, 'add'])->name('admin.first_category.add');
        Route::post('/admin/first_category/insert', [AdminFirstCategorayController::class, 'insert'])->name('admin.first_category.insert');
        Route::get('/admin/first_category/csv_add', [AdminFirstCategorayController::class, 'csv_add'])->name('admin.first_category.csv_add');
        Route::post('/admin/first_category/csv_import', [AdminFirstCategorayController::class, 'csv_import'])->name('admin.first_category.csv_import');
        Route::get('/admin/first_category/list', [AdminFirstCategorayController::class, 'list'])->name('admin.first_category.list');
        Route::get('/admin/first_category/{id}', [AdminFirstCategorayController::class, 'detail'])->name('admin.first_category.detail');
        Route::get('/admin/first_category/edit/{id}', [AdminFirstCategorayController::class, 'edit'])->name('admin.first_category.edit');
        Route::post('/admin/first_category/update', [AdminFirstCategorayController::class, 'update'])->name('admin.first_category.update');
        Route::post('/admin/first_category/delete', [AdminFirstCategorayController::class, 'delete'])->name('admin.first_category.delete');
    
        Route::get('/admin/second_category/add', [AdminSecondCategorayController::class, 'add'])->name('admin.second_category.add');
        Route::post('/admin/second_category/insert', [AdminSecondCategorayController::class, 'insert'])->name('admin.second_category.insert');
        Route::get('/admin/second_category/csv_add', [AdminSecondCategorayController::class, 'csv_add'])->name('admin.second_category.csv_add');
        Route::post('/admin/second_category/csv_import', [AdminSecondCategorayController::class, 'csv_import'])->name('admin.second_category.csv_import');
        Route::get('/admin/second_category/list', [AdminSecondCategorayController::class, 'list'])->name('admin.second_category.list');
        Route::get('/admin/second_category/{id}', [AdminSecondCategorayController::class, 'detail'])->name('admin.second_category.detail');
        Route::get('/admin/second_category/edit/{id}', [AdminSecondCategorayController::class, 'edit'])->name('admin.second_category.edit');
        Route::post('/admin/second_category/update', [AdminSecondCategorayController::class, 'update'])->name('admin.second_category.update');
        Route::post('/admin/second_category/delete', [AdminSecondCategorayController::class, 'delete'])->name('admin.second_category.delete');
    
        Route::get('/admin/product/add', [AdminProductController::class, 'add'])->name('admin.product.add');
        Route::post('/admin/product/insert', [AdminProductController::class, 'insert'])->name('admin.product.insert');
        Route::get('/admin/product/list', [AdminProductController::class, 'list'])->name('admin.product.list');
        Route::get('/admin/product/{id}', [AdminProductController::class, 'detail'])->name('admin.product.detail');
        Route::get('/admin/product/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/admin/product/update', [AdminProductController::class, 'update'])->name('admin.product.update');
        Route::post('/admin/product/delete', [AdminProductController::class, 'delete'])->name('admin.product.delete');
        Route::post('/admin/product/batch_delete', [AdminProductController::class, 'batch_delete'])->name('admin.product.batch_delete');
    
        Route::get('/admin/media/add', [AdminMediaController::class, 'add'])->name('admin.media.add');
        Route::post('/admin/media/insert', [AdminMediaController::class, 'insert'])->name('admin.media.insert');
        Route::get('/admin/media/list', [AdminMediaController::class, 'list'])->name('admin.media.list');
        Route::get('/admin/media/{id}', [AdminMediaController::class, 'detail'])->name('admin.media.detail');
        Route::get('/admin/media/edit/{id}', [AdminMediaController::class, 'edit'])->name('admin.media.edit');
        Route::post('/admin/media/update', [AdminMediaController::class, 'update'])->name('admin.media.update');
        Route::post('/admin/media/delete', [AdminMediaController::class, 'delete'])->name('admin.media.delete');
    
        Route::get('/admin/contact/list', [AdminContactController::class, 'list'])->name('admin.contact.list');
        Route::get('/admin/contact/csv_export', [AdminContactController::class, 'csv_export'])->name('admin.contact.csv_export');
        Route::get('/admin/contact/{id}', [AdminContactController::class, 'detail'])->name('admin.contact.detail');
        Route::post('/admin/contact/status_update', [AdminContactController::class, 'status_update'])->name('admin.contact.status_update');
    
        Route::get('admin/user/login', [AdminUserController::class, 'login'])->name('admin.user.login');
        Route::post('admin/user/login_update', [AdminUserController::class, 'login_update'])->name('admin.user.login_update');
    
    });
});
