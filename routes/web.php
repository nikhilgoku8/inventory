<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSuperAdmin;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\SkuController;

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

        Route::middleware([IsSuperAdmin::class])->group( function (){

            Route::resource('admins', AdminController::class);
            Route::post('/admins/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admins.bulk-delete');

            Route::resource('categories', CategoryController::class);
            Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

            Route::resource('sub-categories', SubCategoryController::class);
            Route::post('sub-categories/bulk-delete', [SubCategoryController::class, 'bulkDelete'])->name('sub-categories.bulk-delete');
            Route::post('get_sub_categories_by_category/{id}', [SubCategoryController::class, 'get_sub_categories_by_category'])->name('get_sub_categories_by_category');
            
            Route::resource('products', ProductController::class);
            Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');

            Route::resource('attributes', AttributeController::class);
            Route::post('/attributes/bulk-delete', [AttributeController::class, 'bulkDelete'])->name('attributes.bulk-delete');

            Route::resource('attribute-values', AttributeValueController::class);
            Route::post('/attribute-values/bulk-delete', [AttributeValueController::class, 'bulkDelete'])->name('attribute-values.bulk-delete');
            Route::post('/get_values_by_attribute/{id}', [AttributeValueController::class, 'get_values_by_attribute'])->name('get_values_by_attribute');
            

            Route::get('/products/{product}/skus/create', [SkuController::class, 'create'])->name('skus.create');
            // Route::post('/products/{product}/skus', [SkuController::class, 'store'])->name('skus.store');

            Route::post('/products/{product}/skus', [SkuController::class, 'store'])->name('skus.store');
            Route::get('/skus/{sku}/edit', [SkuController::class, 'edit'])->name('skus.edit');
            Route::get('/skus', [SkuController::class, 'index'])->name('skus.index');
            Route::get('/skus/{sku}', [SkuController::class, 'show'])->name('skus.show');
            Route::post('/skus/bulk-delete', [SkuController::class, 'bulkDelete'])->name('skus.bulk-delete');
            Route::post('/get_skus_by_product/{id}', [SkuController::class, 'get_skus_by_product'])->name('get_skus_by_product');
        });
            
            Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
            Route::put('/skus/{sku}', [SkuController::class, 'update'])->name('skus.update');

            Route::get('/scan-qr', [SkuController::class, 'scan_qr'])->name('scan_qr');
            Route::post('/skus/validate', [SkuController::class, 'validateSku'])->name('skus.validate');


    });

});