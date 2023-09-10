<?php

use App\Http\Controllers\AuthController;
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

Route::group(["middleware" => ["guest"]], function () {
    Route::get("/login", [AuthController::class, "login_page"])->name("login_page");
    Route::post("/login", [AuthController::class, "login"])->name("login");
});

Route::group(["middleware" => ["auth"]], function () {
    Route::get("/logout", [AuthController::class, "logout"])->name("logout");

    Route::get("/", function () {
        return redirect(route("user.listing"));
    })->name("home");
});
