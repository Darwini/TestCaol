<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DesempenhoController as Desempenho;

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

// Route::get('/', function () { return view('welcome'); });
// Route::any('logout', function(){ Auth::logout();return redirect('login'); });
// Auth::routes();

Route::get('/', function(){ return view('app'); })->name('home');

Route::get('con_desempenho', [Desempenho::class, 'index'])->name('desempenho.index');

Route::post('ajaxConsultores', [Desempenho::class, 'ajaxShowConsultores'])->name('consultarConsultores');