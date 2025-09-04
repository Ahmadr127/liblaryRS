<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LandingController;

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

// Landing page as root
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/about', [LandingController::class, 'about'])->name('about');

// Public materials routes
Route::get('/materials', [LandingController::class, 'materials'])->name('public.materials');
Route::get('/materials/detail/{material}', [LandingController::class, 'materialDetail'])->name('public.material.detail');
Route::get('/materials/files/{materialFile}/download', [MaterialController::class, 'downloadPublic'])->name('materials.files.download');
Route::get('/materials/files/{materialFile}/preview', [MaterialController::class, 'previewPublic'])->name('materials.files.preview');

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
        Route::get('admin/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::get('admin/materials/create', [MaterialController::class, 'create'])->name('materials.create');
        Route::post('admin/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::get('admin/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
        Route::get('admin/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
        Route::put('admin/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
        Route::delete('admin/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
        Route::get('materials/{materialFile}/download', [MaterialController::class, 'download'])->name('materials.download');
        Route::delete('materials/files/{materialFile}', [MaterialController::class, 'deleteFile'])->name('materials.deleteFile');
    });

    // Material preview route - accessible to any authenticated user
    Route::get('materials/files/{materialFile}/preview-auth', [MaterialController::class, 'preview'])->name('materials.preview');

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

    // Storage sync route untuk InfinityFree (opsional)
    Route::middleware('permission:manage_materials')->group(function () {
        Route::get('storage/sync', function () {
            $sourceDir = storage_path('app/public');
            $targetDir = public_path('storage');
            
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            // Simple copy function
            function copyDirectory($src, $dst) {
                $dir = opendir($src);
                @mkdir($dst);
                while (($file = readdir($dir)) !== false) {
                    if ($file != '.' && $file != '..') {
                        if (is_dir($src . '/' . $file)) {
                            copyDirectory($src . '/' . $file, $dst . '/' . $file);
                        } else {
                            copy($src . '/' . $file, $dst . '/' . $file);
                        }
                    }
                }
                closedir($dir);
            }
            
            copyDirectory($sourceDir, $targetDir);
            
            return redirect()->back()->with('success', 'Storage berhasil di-sync!');
        })->name('storage.sync');
    });
});
