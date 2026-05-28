<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\OwnershipTypeController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\TaxeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;

use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    //Any one can Access this API

    Route::get('ownership-types', [OwnershipTypeController::class, 'index']);
    Route::get('business-types', [BusinessTypeController::class, 'index']);
    Route::get('taxes', [TaxeController::class, 'index']);
    Route::post('company-registractions', [CompanyController::class, 'store']);



    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);

        // Role management - requires 'manage-users' permission
        Route::middleware([CheckPermission::class . ':manage-users'])->group(function () {
            Route::get('roles', [RoleController::class, 'index']);
            Route::post('roles', [RoleController::class, 'store']);
            Route::post('roles/{role}/users/{user}', [RoleController::class, 'assignUser']);
            Route::post('roles/{role}/permissions/{permission}', [RoleController::class, 'attachPermission']);
        });

        // Permission management - requires 'manage-users' permission
        Route::middleware([CheckPermission::class . ':manage-users'])->group(function () {
            Route::get('permissions', [PermissionController::class, 'index']);
            Route::post('permissions', [PermissionController::class, 'store']);
        });

        // Unit management - requires 'manage-units' permission
        Route::middleware([CheckPermission::class . ':manage-units'])->group(function () {
            Route::get('units', [UnitController::class, 'index']);
            Route::post('units', [UnitController::class, 'store']);
            Route::get('units/{unit}', [UnitController::class, 'show']);
            Route::match(['put', 'patch'], 'units/{unit}', [UnitController::class, 'update']);
            Route::delete('units/{unit}', [UnitController::class, 'destroy']);
        });

                // Ownership Type management - requires 'manage-ownership-types' permission
        Route::middleware([CheckPermission::class . ':manage-ownership-types'])->group(function () {
            // Route::get('ownership-types', [OwnershipTypeController::class, 'index']);
            Route::post('ownership-types', [OwnershipTypeController::class, 'store']);
            Route::get('ownership-types/{ownershipType}', [OwnershipTypeController::class, 'show']);
            // Route::match(['put', 'patch'], 'ownership-types/{ownershipType}', [OwnershipTypeController::class, 'update']);
            Route::delete('ownership-types/{ownershipType}', [OwnershipTypeController::class, 'destroy']);
        });

                        // Ownership Type management - requires 'manage-ownership-types' permission
        Route::middleware([CheckPermission::class . ':manage-business-types'])->group(function () {
            // Route::get('ownership-types', [BusinessTypeController::class, 'index']);
            Route::post('business-types', [BusinessTypeController::class, 'store']);
            Route::get('business-types/{businessType}', [BusinessTypeController::class, 'show']);
            // Route::match(['put', 'patch'], 'business-types/{businessType}', [BusinessTypeController::class, 'update']);
            Route::delete('business-types/{businessType}', [BusinessTypeController::class, 'destroy']);
        });

               // Taxe  management - requires 'manage-taxes' permission
        Route::middleware([CheckPermission::class . ':manage-taxes'])->group(function () {
            // Route::get('taxes', [TaxeController::class, 'index']);
            Route::post('taxes', [TaxeController::class, 'store']);
            Route::get('taxes/{taxe}', [TaxeController::class, 'show']);
            Route::match(['put', 'patch'], 'taxes/{taxe}', [TaxeController::class, 'update']);
            Route::delete('taxes/{taxe}', [TaxeController::class, 'destroy']);
        });

             // Customer  management - requires 'manage-taxes' permission
        Route::middleware([CheckPermission::class . ':manage-taxes'])->group(function () {
            Route::get('/customers/search', [CustomerController::class, 'search']);
            // Route::get('taxes', [TaxeController::class, 'index']);
            Route::post('customers', [CustomerController::class, 'store']);
            Route::get('customers/{id}', [CustomerController::class, 'show']);
            Route::match(['put', 'patch'], 'customers/{taxe}', [CustomerController::class, 'update']);
            Route::delete('customers/{id}', [CustomerController::class, 'destroy']);
        });

            Route::middleware([CheckPermission::class . ':manage-company'])->group(function () {
            Route::get('companies', [CompanyController::class, 'index']);
            Route::post('companies', [CompanyController::class, 'store']);
            Route::get('companies/{company}', [CompanyController::class, 'show']);
            Route::match(['put', 'patch'], 'company/{company}', [CompanyController::class, 'update']);
            Route::delete('companies/{company}', [CompanyController::class, 'destroy']);
        });
    });
});
