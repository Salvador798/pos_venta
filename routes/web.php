<?php

use App\Config\Route;
use App\Controllers\AdministracionController;
use App\Controllers\CajaController;
use App\Controllers\CategoriasController;
use App\Controllers\ClientesController;
use App\Controllers\ComprasController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\MedidasController;
use App\Controllers\ProductosController;
use App\Controllers\UsuariosController;

// Login
Route::get('/', [HomeController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

// Administracion
Route::get('/administration', [AdministracionController::class, 'index']);
Route::get('/administration/home', [AdministracionController::class, 'home']);
Route::post('administration/modify', [AdministracionController::class, 'modify']);
Route::get('/administration/reportStock', [AdministracionController::class, 'reportStock']);
Route::get('/administration/productsSold', [AdministracionController::class, 'productsSold']);

// Usuarios
Route::get('/users', [UsuariosController::class, 'index']);
Route::get('/users/list', [UsuariosController::class, 'list']);
Route::get('/users/permisos/{id}', [UsuariosController::class, 'permisos']);
Route::post('/users', [UsuariosController::class, 'store']);
Route::get('/users/{id}', [UsuariosController::class, 'edit']);
Route::post('/users/desactive/{id}', [UsuariosController::class, 'desactive']);
Route::post('/users/active/{id}', [UsuariosController::class, 'active']);
Route::post('/users/registerPermiso', [UsuariosController::class, 'registrarPermiso']);
Route::post('/users/cambiarPass', [UsuariosController::class, 'cambiarPass']);

// Categorias
Route::get('/categories', [CategoriasController::class, 'index']);
Route::post('/categories', [CategoriasController::class, 'store']);
Route::get('/categories/list', [CategoriasController::class, 'list']);
Route::get('/categories/{id}', [CategoriasController::class, 'edit']);
Route::post('/categories/desactive/{id}', [CategoriasController::class, 'desactive']);
Route::post('/categories/active/{id}', [CategoriasController::class, 'active']);

// Medidas
Route::get('/extends', [MedidasController::class, 'index']);
Route::post('/extends', [MedidasController::class, 'store']);
Route::get('/extends/list', [MedidasController::class, 'list']);
Route::get('/extends/{id}', [MedidasController::class, 'edit']);
Route::post('/extends/desactive/{id}', [MedidasController::class, 'desactive']);
Route::post('/extends/active/{id}', [MedidasController::class, 'active']);

// Productos
Route::get('/products', [ProductosController::class, 'index']);
Route::post('/products', [ProductosController::class, 'store']);
Route::get('/products/list', [ProductosController::class, 'list']);
Route::get('/products/{id}', [ProductosController::class, 'edit']);
Route::post('/products/desactive/{id}', [ProductosController::class, 'desactive']);
Route::post('/products/active/{id}', [ProductosController::class, 'active']);

// Clientes
Route::get('/clients', [ClientesController::class, 'index']);
Route::post('/clients', [ClientesController::class, 'store']);
Route::get('/clients/list', [ClientesController::class, 'list']);
Route::get('/clients/{id}', [ClientesController::class, 'edit']);
Route::post('/clients/desactive/{id}', [ClientesController::class, 'desactive']);
Route::post('/clients/active/{id}', [ClientesController::class, 'active']);

// Cajas
Route::get('/boxes', [CajaController::class, 'index']);
Route::post('/boxes', [CajaController::class, 'store']);
Route::get('/boxes/list', [CajaController::class, 'list']);
Route::get('/boxes/{id}', [CajaController::class, 'edit']);
Route::post('/boxes/desactive/{id}', [CajaController::class, 'desactive']);
Route::post('/boxes/active/{id}', [CajaController::class, 'active']);

// Arqueo Cajas
Route::get('/arqueo', [CajaController::class, 'arqueo']);
Route::post('/arqueo', [CajaController::class, 'openArqueo']);
Route::get('/arqueo/listArqueo', [CajaController::class, 'listArqueo']);
Route::get('/arqueo/getSales', [CajaController::class, 'getSales']);

// Compras
Route::get('/shopping', [ComprasController::class, 'index']);
Route::get('/shopping/searchCode/{id}', [ComprasController::class, 'searchCode']);
Route::post('/shopping/getInto', [ComprasController::class, 'getInto']);
Route::get('/shopping/list/{detalle}', [ComprasController::class, 'list']);
Route::get('/shopping/delete/{id}', [ComprasController::class, 'delete']);
Route::get('/shopping/registerPurchase', [ComprasController::class, 'registerPurchase']);
Route::get('/shopping/generatePDF/{id}', [ComprasController::class, 'generatePDF']);
Route::get('/shopping/historial', [ComprasController::class, 'historial']);
Route::get('/shopping/list_historial', [ComprasController::class, 'list_historial']);
Route::post('/shopping/anularShopping/{id}', [ComprasController::class, 'anularShopping']);
Route::post('/shopping/pdfShopping', [ComprasController::class, 'pdfShopping']);
Route::get('/shopping/pdfShopping', [ComprasController::class, 'pdfShopping']);

// Ventas
Route::get('/sales', [ComprasController::class, 'sales']);
Route::get('/shopping/searchCode/{id}', [ComprasController::class, 'searchCode']);
Route::post('/shopping/enterSale', [ComprasController::class, 'enterSale']);
Route::get('/shopping/list/{detalle_temp}', [ComprasController::class, 'list']);
Route::get('/shopping/calculateDiscount/{id}/{value}', [ComprasController::class, 'calculateDiscount']);
Route::get('/shopping/deleteSale/{id}', [ComprasController::class, 'deleteSale']);
Route::get('/shopping/registerSale/{id_cliente}', [ComprasController::class, 'registerSale']);
Route::get('/shopping/generatePdfSale/{id}', [ComprasController::class, 'generatePdfSale']);
Route::get('/shopping/historialSales', [ComprasController::class, 'historialSales']);
Route::get('/shopping/listHistorialSale', [ComprasController::class, 'listHistorialSale']);
Route::post('/shopping/anularSale/{id}', [ComprasController::class, 'anularSale']);
Route::post('/shopping/pdfSale', [ComprasController::class, 'pdfSale']);
Route::get('/shopping/pdfSale', [ComprasController::class, 'pdfSale']);
