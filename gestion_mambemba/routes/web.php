<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\InscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web - Gestion Mambemba
|--------------------------------------------------------------------------
*/

// === PAGES PUBLIQUES ===
Route::get('/', function () {
    $sections = \App\Models\Section::all();
    return view('accueil', compact('sections'));
})->name('accueil');

Route::get('/apropos', function () {
    return view('apropos');
})->name('apropos');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// === INSCRIPTION (seul flux protégé : connexion exigée) ===
Route::middleware('auth')->group(function () {
    Route::get('/inscription', [InscriptionController::class, 'create'])->name('inscription');
    Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');
});

// === AUTHENTIFICATION ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/connexion', [AuthController::class, 'showLoginForm'])->name('connexion');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === DASHBOARD (public) ===
Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');

// === ÉLÈVES (public) ===
Route::get('/eleves', [EleveController::class, 'index'])->name('eleves');
Route::get('/impression/eleves-par-section', [EleveController::class, 'impressionParSection'])->name('eleves.impression.sections');
Route::put('/eleves/{eleve}', [EleveController::class, 'update'])->name('eleves.update');
Route::delete('/eleves/{eleve}', [EleveController::class, 'destroy'])->name('eleves.destroy');

// === PARAMÈTRES (public) ===
Route::get('/parametres', function () {
    return view('parametres');
})->name('parametres');
