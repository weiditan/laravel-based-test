<?php

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

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::prefix("user")
    ->name("user.")
    ->group(function () {
        Route::get("/", [UserController::class, "user_listing"])->name("listing");
        Route::get("/export", [UserController::class, "user_export"])->name("export");

        Route::get("/add", [UserController::class, "user_form"])->name("add");
        Route::get("/edit/{user_id}", [UserController::class, "user_form"])->name("edit");
        Route::post("/create", [UserController::class, "user_update_or_create"])->name("create");
        Route::post("/update", [UserController::class, "user_update_or_create"])->name("update");
        Route::post("/delete", [UserController::class, "user_delete"])->name("delete");

        Route::get("/{user_id}", [UserController::class, "user_detail"])->name("detail");
    });
