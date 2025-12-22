<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('iwm')->as('admin.')->group(function(){
    
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'] )->name('authenticate');
    Route::get('/logout', [LoginController::class, 'logout'] )->name('logout');

    Route::middleware([IsAdmin::class])->group( function (){
            
            // Route::get('/admins', [AdminsController::class, 'index'] );
            // Route::get('/admins/create', [AdminsController::class, 'create'] );
            // Route::get('/admins/edit/{id}', [AdminsController::class, 'edit'] );
            // Route::post('/admins/store', [AdminsController::class, 'store'] );
            // Route::post('/admins/delete', [AdminsController::class, 'delete'] );
            // Route::get('/admins/usertype/{id}', [AdminsController::class, 'usertype'] );
            
            Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

            Route::resource('admins', AdminController::class);
            Route::post('/admins/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admins.bulk-delete');

            Route::resource('categories', CategoryController::class);
            Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

            Route::resource('sub-categories', SubCategoryController::class);
            Route::post('sub-categories/bulk-delete', [SubCategoryController::class, 'bulkDelete'])->name('sub-categories.bulk-delete');
            Route::post('get_sub_categories_by_category/{id}', [SubCategoryController::class, 'get_sub_categories_by_category'])->name('get_sub_categories_by_category');
            
            Route::resource('products', ProductController::class);
            Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');

    });

});