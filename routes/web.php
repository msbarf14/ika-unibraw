<?php

use App\Livewire\Web\BukuTamu;
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

Route::get('/', \App\Livewire\Web\Home::class);

Route::get('/news', \App\Livewire\Web\News::class)->name('news');
Route::get('/news/{post:slug}', \App\Livewire\Web\Post::class)->name('post');

Route::get('/form/{schema:slug}', \App\Livewire\Form::class)->name('public-form');
Route::get('/buku-tamu', BukuTamu::class)->name('buku-tamu');

// Put at End Of Route
Route::get('/{page:slug}', \App\Livewire\Web\Page::class)->name('page');
