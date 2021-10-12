<?php

use Illuminate\Support\Facades\Route;

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

// Producto Routes //
Route::get('/productos/cat/{cat}', [App\Http\Controllers\ProductoController::class, 'cat'])->name('productosCat');
Route::get('/', [App\Http\Controllers\SobremodeloController::class, 'index'])->name('sobremodelos');
Route::get('/detalle/{id}', [App\Http\Controllers\ProductoController::class, 'idProd'])->name('idProd');
Route::get('/detalle/{producto_id}/{sobremodelo_id}', [App\Http\Controllers\ProductoController::class, 'detalleextra'])->name('detalleextra');
Route::get('/productos/cat/{cat}/mayor', [App\Http\Controllers\ProductoController::class, 'precioMayor'])->name('precioMayor');
Route::get('/productos/cat/{cat}/menor', [App\Http\Controllers\ProductoController::class, 'precioMenor'])->name('precioMenor');
Route::get('/nuevo-producto', [App\Http\Controllers\ProductoController::class, 'nuevoProducto'])->middleware(['auth'])->name('nuevoProducto');
Route::get('/nueva-cat', [App\Http\Controllers\CategoriaController::class, 'nuevaCat'])->middleware(['auth'])->name('nuevaCat');
Route::get('/nueva-subcat', [App\Http\Controllers\SubcategoriaController::class, 'nuevaSubCat'])->middleware(['auth'])->name('nuevaSubCat');
Route::post('/updateProducto', [App\Http\Controllers\ProductoController::class, 'updateProducto'])->middleware(['auth'])->name('updateProducto');
Route::get('/buscar', [App\Http\Controllers\ProductoController::class, 'buscarIndex'])->name('buscarIndex');
Route::get('/resultado', [App\Http\Controllers\ProductoController::class, 'scopeBuscarProducto'])->name('buscarProducto');

////// Sobremodelo ////////
Route::get('/nuevo-sobremodelo', [App\Http\Controllers\SobremodeloController::class, 'nuevoSobremodelo'])->middleware(['auth'])->name('nuevoSobremodelo');
Route::post('/ingresarsobremodelo', [App\Http\Controllers\SobremodeloController::class, 'ingresarSobremodelo'])->middleware(['auth'])->name('ingresarSobremodelo');
Route::get('/lista-sobremodelos-estado', [App\Http\Controllers\SobremodeloController::class, 'estadoSelect'])->middleware(['auth'])->name('estadoSobremodeloSelect');
Route::post('/updateEstadoSM', [App\Http\Controllers\SobremodeloController::class, 'estadoUpdateSobremodelo'])->middleware(['auth'])->name('estadoUpdateSobremodelo');
Route::get('/lista-sobremodelos', [App\Http\Controllers\SobremodeloController::class, 'showListaSobremodelos'])->middleware(['auth'])->name('showListaSobremodelos');
Route::post('/deleteSobremodelo', [App\Http\Controllers\SobremodeloController::class, 'confirmarEliminarSobremodelo'])->middleware(['auth'])->name('confirmarEliminarSobremodelo');
Route::get('/eliminarSobremodelo', [App\Http\Controllers\SobremodeloController::class, 'showEliminarSobremodelo'])->middleware(['auth'])->name('showEliminarSobremodelo');
Route::get('/editarSobremodelo', [App\Http\Controllers\SobremodeloController::class, 'showEditarSobremodelo'])->middleware(['auth'])->name('showEditarSobremodelo');
Route::post('/updateSobremodelo', [App\Http\Controllers\SobremodeloController::class, 'confirmarEditarSobremodelo'])->middleware(['auth'])->name('confirmarEditarSobremodelo');

// CRUD Categorias //

Route::post('/ingresarcategoria', [App\Http\Controllers\CategoriaController::class, 'ingresarCat'])->middleware(['auth'])->name('ingresarCat');
Route::post('/ingresarsubcategoria', [App\Http\Controllers\SubcategoriaController::class, 'ingresarSubCat'])->middleware(['auth'])->name('ingresarSubCat');
Route::get('/editarCategoria', [App\Http\Controllers\CategoriaController::class, 'showEditarCategoria'])->middleware(['auth'])->name('showEditarCategoria');
Route::post('/updateCategoria', [App\Http\Controllers\CategoriaController::class, 'confirmarEditarCategoria'])->middleware(['auth'])->name('confirmarEditarCategoria');
Route::get('/editarSubcategoria', [App\Http\Controllers\SubcategoriaController::class, 'showEditarSubcategoria'])->middleware(['auth'])->name('showEditarSubcategoria');
Route::post('/updateSubcategoria', [App\Http\Controllers\SubcategoriaController::class, 'confirmarEditarSubcategoria'])->middleware(['auth'])->name('confirmarEditarSubcategoria');

/////// CRUD Producto /////////

Route::post('/ingresarproducto', [App\Http\Controllers\ProductoController::class, 'ingresarProducto'])->middleware(['auth'])->name('ingresarProducto');
Route::get('/editarProducto/{id}', [App\Http\Controllers\ProductoController::class, 'editarProducto'])->middleware(['auth'])->name('editarProducto');
Route::get('/eliminarProducto/{id}', [App\Http\Controllers\ProductoController::class, 'eliminarProducto'])->middleware(['auth'])->name('eliminarProducto');
Route::post('/deleteProduct', [App\Http\Controllers\ProductoController::class, 'confirmarEliminarProducto'])->middleware(['auth'])->name('confirmarEliminarProducto');
Route::get('/lista-productos-estado', [App\Http\Controllers\ProductoController::class, 'estadoProductoSelect'])->middleware(['auth'])->name('estadoProductoSelect');
Route::post('/updateEstadoP', [App\Http\Controllers\ProductoController::class, 'estadoUpdateProducto'])->middleware(['auth'])->name('estadoUpdateProducto');
Route::get('/lista-productos', [App\Http\Controllers\ProductoController::class, 'showListaProductos'])->middleware(['auth'])->name('showListaProductos');
Route::get('/buscar-lista-productos', [App\Http\Controllers\ProductoController::class, 'buscarListaProductos'])->middleware(['auth'])->name('buscarListaProductos');

Route::get('/lista-productos-precio', [App\Http\Controllers\ProductoController::class, 'showListaProductosPrecio'])->middleware(['auth'])->name('showListaProductosPrecio');
Route::get('/lista-productos-estado-precio', [App\Http\Controllers\ProductoController::class, 'estadoPrecioSelect'])->middleware(['auth'])->name('estadoPrecioSelect');
Route::post('/updatePrecio', [App\Http\Controllers\ProductoController::class, 'precioUpdate'])->middleware(['auth'])->name('precioUpdate');
Route::get('/buscar-lista-productos-precio', [App\Http\Controllers\ProductoController::class, 'buscarListaProductosPrecios'])->middleware(['auth'])->name('buscarListaProductosPrecios');








// ListaUsuario Routes //
Route::get('/lista-usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->middleware(['auth'])->name('lista-usuarios');
Route::get('/lista-usuarios-rol', [App\Http\Controllers\UsuarioController::class, 'rolSelect'])->middleware(['auth'])->name('lista-usuariosRolSelect');
Route::post('/updateRol', [App\Http\Controllers\UsuarioController::class, 'rolUpdate'])->middleware(['auth'])->name('updateRol');

// Carrito Routes //
Route::post('/agregar', [App\Http\Controllers\CarroController::class, 'carritoSaveProducto'])->middleware(['auth'])->name('carritoSaveProducto');
Route::get('/carro', [App\Http\Controllers\CarroController::class, 'show'])->middleware(['auth'])->name('showCarro');

// Carrito Add, Remove, Reset y Delete //
Route::post('/addone', [App\Http\Controllers\CarroController::class, 'addOne'])->middleware(['auth'])->name('addone');
Route::post('/removeone', [App\Http\Controllers\CarroController::class, 'removeOne'])->middleware(['auth'])->name('removeone');
Route::post('/deleteall', [App\Http\Controllers\CarroController::class, 'deleteAll'])->middleware(['auth'])->name('deleteall');
Route::post('/resetall', [App\Http\Controllers\CarroController::class, 'resetAll'])->middleware(['auth'])->name('resetall');
// Carrito enviar pedido y borrar carrito //
Route::get('/enviarpedido', [App\Http\Controllers\CarroController::class, 'enviarPedido'])->middleware(['auth'])->name('enviarpedido');
Route::get('/exito', [App\Http\Controllers\CarroController::class, 'exito'])->middleware(['auth'])->name('exito');
Route::get('/error', [App\Http\Controllers\CarroController::class, 'error'])->middleware(['auth'])->name('error');






require __DIR__.'/auth.php';
