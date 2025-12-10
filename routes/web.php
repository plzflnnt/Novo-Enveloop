<?php

use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Enveloop
|--------------------------------------------------------------------------
*/

// Rota inicial - redireciona para home se autenticado
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return view('welcome');
})->name('welcome');

// Rotas de autenticação (criadas pelo Breeze)
require __DIR__.'/auth.php';

// Rotas protegidas (requerem autenticação)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal (HOME do Enveloop)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Rota /dashboard redireciona para /home (compatibilidade com Breeze)
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');
    
    // Perfil do usuário (do Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========================================
    // ROTAS DO ENVELOOP
    // ========================================
    
    // Gerenciamento de envelopes
    Route::post('/new-envelope', [EnvelopeController::class, 'createEnvelope'])->name('envelope.create');
    Route::get('/envelope/{id}', [EnvelopeController::class, 'envelope'])->name('envelope.show');
    
    // Transações - Ganhos
    Route::post('/new-earning', [EnvelopeController::class, 'createEarning'])->name('earning.create');
    
    // Transações - Despesas
    Route::post('/new-expense', [EnvelopeController::class, 'createExpense'])->name('expense.create');
    
    // Desfazer transação
    Route::get('/undo-earning/{id}', [EnvelopeController::class, 'undoEarning'])->name('undo-earning');
    
    // Visualização de transações
    Route::get('/transactions', [EnvelopeController::class, 'transactions'])->name('transactions');
    
    // Relatórios
    Route::get('/report', [EnvelopeController::class, 'report'])->name('report');
    
    // Changelog
    Route::get('/changelog', [EnvelopeController::class, 'changelog'])->name('changelog');
});