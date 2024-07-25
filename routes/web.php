<?php

use App\Http\Controllers\CarritoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Models\Categoria;

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

// Login
Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('priv', function () {
    return view('priv');
})->name('priv');

Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');
Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');

//Categorias
Route::get('/obtenerCategorias', [CategoriaController::class, 'obtenerCategorias']);
Route::post('/crearCategoria', [CategoriaController::class, 'store'])->name('crear.categoria');
Route::delete('/eliminarCategoria/{categoriaId}', [Categoria::class, 'destroy']);
Route::put('/editarCategoria/{categoriaId}', [CategoriaController::class, 'update'])->name('editar.categoria');


//Productos
Route::get('/obtenerProductosPorCategoria/{categoriaId}', [ProductoController::class, 'obtenerProductosPorCategoria']);
Route::post('/crearProducto', [ProductoController::class, 'store'])->name('crear.producto.store');
Route::delete('/eliminarProducto/{id}', [ProductoController::class, 'destroy'])->name('eliminar.producto');

//Carrito
Route::get('/obtenerCarrito', [CarritoController::class, 'obtenerCarrito']);
Route::any('/addAlCarrito/{productId}', [CarritoController::class, 'addAlCarrito'])->name('addAlCarrito');
Route::delete('/eliminarDelCarrito/{productId}', [CarritoController::class, 'eliminarDelCarrito'])->name('eliminarDelCarrito');

//Pedido
Route::get('/finalizarPedido/{usuarioId}', [PedidoController::class, 'finalizarPedido'])->name('finalizarPedido');

