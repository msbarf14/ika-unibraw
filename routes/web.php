<?php

use App\Livewire\Web\BukuTamu;
use App\Livewire\Web\Donasi;
use App\Livewire\Web\Donasi\Detail as DetailDonasi;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Web\Home::class);
Route::get('/vidio', \App\Livewire\Web\VideoScreen::class);
Route::get('/donasi', Donasi::class)->name('donasi');
Route::get('/donasi/{campaign:id}', DetailDonasi::class)->name('donasi.detail');
Route::get('/search', \App\Livewire\Web\Search::class)->name('post.search');

Route::get('/news', \App\Livewire\Web\News::class)->name('news');
Route::get('/news/{post:slug}', \App\Livewire\Web\Post::class)->name('post');

Route::get('/form/{schema:slug}', \App\Livewire\Form::class)->name('public-form');
Route::get('/buku-tamu', BukuTamu::class)->name('buku-tamu');

Route::get('/{page:slug}', \App\Livewire\Web\Page::class)->name('page');

Route::get('/category/{category:slug}', \App\Livewire\Web\Category::class)->name('category');
