<?php

use App\Http\Controllers\AppController;
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

Route::get('/', [AppController::class, "login"])->name("connexion");

Route::post('/login', [AppController::class, "login_submit"])->name("login");
Route::get('/register', [AppController::class, "register"])->name("inscription");
Route::post('/register', [AppController::class, "register_submit"])->name("register_submit");

Route::get("/home", [AppController::class, "home"])->name("home");
Route::get("/vocal", [AppController::class, "vocal"])->name("vocal");
Route::post("/piece", [AppController::class, "piece_ajout"])->name("piece_ajout");
Route::post("/user-appareil", [AppController::class, "user_appareil_ajout"])->name("appareil_ajout");
Route::get("/liste-appareil/{id}", [AppController::class, "piece_app_list"])->name("list_app");
Route::get("/piece-supp/{id}", [AppController::class, "list_appareil"])->name("piece_supp");
Route::get("/appareil-status/{appareil_id}/{id_piece}", [AppController::class, "status_appareil"]);
