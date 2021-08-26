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
Route::get('/', function () {
    return view('sitio.login');
});
Route::get('login', function () {
    return view('sitio.login');
})->name('login');

Route::get('index', 'UsuarioController@index')->name('index');

Route::post('usuario/auth', 'UsuarioController@auth')->name('usuario/auth');
Route::get('usuario/logout', 'UsuarioController@logout')->name('logout');

Route::any('tercero/administrar', 'TerceroController@administrar')->name('tercero/administrar');
Route::any('tercero/crear', 'TerceroController@crear')->name('tercero/crear');
Route::any('tercero/editar/{id_tercero}', 'TerceroController@crear')->name('tercero/editar');
Route::any('tercero/view/{id_tercero}', 'TerceroController@view')->name('tercero/view');
Route::any('tercero/buscar/{caracteres}', 'TerceroController@buscar')->name('tercero/buscar');

Route::any('factura/crear', 'FacturaController@crear')->name('factura/crear');
Route::any('cotizacion/crear', 'FacturaController@crear')->name('factura/crear');
Route::any('factura/finalizar_factura', 'FacturaController@finalizar_factura')->name('factura/finalizar_factura');
Route::any('factura/imprimir/{id_factura}', 'FacturaController@imprimir')->name('factura/imprimir');

Route::any('factura/facturador', 'FacturaController@facturador')->name('factura/facturador');

Route::any('producto/buscar/{id_producto}', 'ProductoController@buscar')->name('producto/buscar');
Route::any('producto/administrar', 'ProductoController@administrar')->name('producto/administrar');
Route::any('producto/crear', 'ProductoController@guardar')->name('producto/crear');
Route::any('producto/editar/{id_producto}', 'ProductoController@guardar')->name('producto/editar');
Route::any('producto/view/{id_producto}', 'ProductoController@view')->name('producto/view');

Route::any('categoria/administrar', 'CategoriaController@administrar')->name('categoria/administrar');
Route::any('categoria/crear', 'CategoriaController@guardar')->name('categoria/crear');
Route::any('categoria/editar/{id_producto}', 'CategoriaController@guardar')->name('categoria/editar');

Route::any('inventario/movimientos', 'InventarioController@administrar')->name('inventario/movimientos');
Route::any('inventario/crear', 'InventarioController@guardar')->name('inventario/crear');
Route::any('inventario/vista/{id_inventario}', 'InventarioController@vista')->name('inventario/vista');

Route::any('reportes/facturas', 'ReporteController@facturas')->name('producto/buscar');
Route::get('factura_email', function () {
    return view('email.factura');
})->name('factura_email');

Route::get('factura_pdf', function () {
    return view('pdf.factura');
})->name('factura_pdf');
