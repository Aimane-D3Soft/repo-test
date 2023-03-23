<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();
Route::group(['middleware' =>'auth'], function(){
    Route::post('add-category', [CategoryController::class, 'create'])->name('add_category');
    Route::post('/add-tag', [TagController::class, 'create'])->name('add_tags');
    Route::post('/add-product', [ProductController::class, 'create'])->name('add_products');
    Route::get('/index', [ProductController::class, 'index']);
    Route::get('/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update_product');
    Route::delete('/delete-product/{id}', [ProductController::class, 'delete'])->name('delete_product');
    Route::get('/exports', [ProductController::class, 'export'])->name('download_products');
    Route::get('/export-tagProduct', [ProductController::class, 'exportProductTag'])->name('download_product-tag');
    Route::get('/export-category', [ProductController::class, 'exportCategory'])->name('download_product-category');
    Route::post('/import', [ProductController::class, 'importProduct'])->name('upload_product');
    Route::post('/import-tag', [ProductController::class, 'importProductTag'])->name('upload_product-tag');
    Route::post('/import-category', [ProductController::class, 'importCategory'])->name('upload_categories');
    Route::get('/print_product', [ProductController::class, 'productPDF'])->name('product_pdf');
    Route::post('/send_mail', [ProductController::class, 'sendEmail'])->name('email');
    Route::post('add_roles', [UserController::class, 'createRoles'])->name('add_roles');
    Route::post('creat_groupe', [UserController::class, 'createGroup'])->name('create_groupe');
    Route::post('/group-permssion', [UserController::class, 'createGroupPermssion'])->name('group_permissions');
    Route::get('test', [UserController::class, 'index']);
    Route::get('/create/{id}', [UserController::class, 'show']);
    Route::get('/get-group/{id}', [UserController::class, 'showPermission']);
    Route::get('/check-permission', [UserController::class, 'permission']);    

    Route::controller(UserController::class)->group(function (){

    });
    Route::get('/product', function () {
        return view('product');
    });
    Route::get('/email/write', function () {
        return view('email.write');
    });
    Route::get('/email/send', function () {
        return view('email.send');
    });
    Route::get('/roles/show', function (){
        return view('roles.show');
    });
    // Route::get('/roles/create', [UserController::class, 'showGroups']);
    Route::get('/roles/create', [UserController::class, 'showGroups']);
});
Route::group(['middleware' => ['group:Administrateur']], function() {
    Route::get('/product', [ProductController::class, 'show']);
});