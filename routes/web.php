<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{FamiliaController,CategoriaController,ProductoController,AjaxController};
use App\Models\Producto;

Route::get('/', function(){ return redirect()->route('dashboard'); });

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::resource('familias', FamiliaController::class)->only(['index']);
    Route::resource('categorias', CategoriaController::class)->except(['create','edit','show']);
    Route::resource('productos', ProductoController::class)->except(['create','edit','show']);

    // Imágenes
    Route::delete('productos/image/{image}', [ProductoController::class,'deleteImage'])->name('productos.image.delete');

    // AJAX dependiente
    Route::get('ajax/categorias/by-familia/{familia}', [AjaxController::class,'categoriasByFamilia'])->name('ajax.categorias.byfamilia');
});