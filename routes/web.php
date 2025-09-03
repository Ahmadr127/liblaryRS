<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Material routes with permission middleware
    Route::middleware('permission:manage_materials')->group(function () {
        Route::resource('materials', MaterialController::class);
        Route::get('materials/{materialFile}/download', [MaterialController::class, 'download'])->name('materials.download');
        Route::delete('materials/files/{materialFile}', [MaterialController::class, 'deleteFile'])->name('materials.deleteFile');
    });

    // Material preview route - accessible to any authenticated user
    Route::get('materials/files/{materialFile}/preview', [MaterialController::class, 'preview'])->name('materials.preview');

    // Material modal route - accessible to any authenticated user (view details only)
    Route::get('materials/{material}/modal', [MaterialController::class, 'modal'])->name('materials.modal');

    // Material view route for regular users
    Route::middleware('permission:view_materials')->group(function () {
        Route::get('materials/user/list', [MaterialController::class, 'materialsForUser'])->name('materials.materialsforuser');
    });

    // User Management routes
    Route::middleware('permission:manage_users')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Role Management routes
    Route::middleware('permission:manage_roles')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // Permission Management routes
    Route::middleware('permission:manage_permissions')->group(function () {
        Route::resource('permissions', PermissionController::class);
    });

    // Categories: view list for viewers, manage for managers
    Route::middleware('permission:view_categories')->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    });
    Route::middleware('permission:manage_categories')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
    });
});
