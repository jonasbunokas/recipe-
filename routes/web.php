<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AuthorManagement;
use App\Livewire\RecipeManagement;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/authors', AuthorManagement::class)->name('authors');
Route::get('/recipes', RecipeManagement::class)->name('recipes');