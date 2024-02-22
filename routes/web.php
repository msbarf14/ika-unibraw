<?php

use App\Livewire\Web\BukuTamu;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Web\Home::class);

Route::get('/news', \App\Livewire\Web\News::class)->name('news');
Route::get('/news/{post:slug}', \App\Livewire\Web\Post::class)->name('post');

Route::get('/form/{schema:slug}', \App\Livewire\Form::class)->name('public-form');
Route::get('/buku-tamu', BukuTamu::class)->name('buku-tamu');

// Put at End Of Route
Route::get('/{page:slug}', \App\Livewire\Web\Page::class)->name('page');
Route::get('/category/{category:slug}', \App\Livewire\Web\Category::class)->name('category');
