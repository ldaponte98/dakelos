<?php

use Illuminate\Support\Facades\Route;
use App\Log;
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
})->name('/');
Route::get('/test', function () {
    return view('app.test');
});
Route::get('login', function () {
    return view('sitio.login');
})->name('login');

Route::get('index', 'UsuarioController@index')->name('index');
Route::get('menu/{token}', 'AppController@menu')->name('menu');

Route::post('usuario/auth', 'UsuarioController@auth')->name('usuario/auth');
Route::get('usuario/logout', 'UsuarioController@logout')->name('logout');
Route::any('usuario/administrar', 'UsuarioController@administrar')->name('usuario/administrar');
Route::any('usuario/crear', 'UsuarioController@guardar')->name('usuario/crear');
Route::any('usuario/editar/{id_usuario}', 'UsuarioController@guardar')->name('usuario/editar');

Route::any('tercero/administrar', 'TerceroController@administrar')->name('tercero/administrar');
Route::any('tercero/crear', 'TerceroController@crear')->name('tercero/crear');
Route::any('tercero/editar/{id_tercero}', 'TerceroController@crear')->name('tercero/editar');
Route::any('tercero/view/{id_tercero}', 'TerceroController@view')->name('tercero/view');
Route::any('tercero/buscar/{caracteres}', 'TerceroController@buscar')->name('tercero/buscar');
Route::any('tercero/buscar/{caracteres}', 'TerceroController@buscar')->name('tercero/buscar');
Route::post('tercero/validar_ahorros_para_uso', 'TerceroController@validar_ahorros_para_uso')->name('tercero/validar_ahorros_para_uso');

Route::any('factura/crear', 'FacturaController@crear')->name('factura/crear');
Route::post('factura/anular', 'FacturaController@anular')->name('factura/anular');
Route::any('cotizacion/crear', 'FacturaController@crear')->name('factura/crear');
Route::any('factura/finalizar_factura', 'FacturaController@finalizar_factura')->name('factura/finalizar_factura');
Route::any('factura/imprimir/{id_factura}', 'FacturaController@imprimir')->name('factura/imprimir');
Route::any('ticket/imprimir/comanda/{id_factura}', 'FacturaController@imprimir_ticket_comanda')->name('ticket/imprimir/comanda');
Route::any('ticket/imprimir/factura/{id_factura}', 'FacturaController@imprimir_ticket_factura')->name('ticket/imprimir/factura');

Route::any('factura/facturador', 'FacturaController@facturador')->name('factura/facturador');
Route::post('factura/finalizar_factura_facturador', 'FacturaController@finalizar_factura_facturador')->name('factura/finalizar_factura_facturador');
Route::post('factura/pagar_credito', 'FacturaController@pagar_credito')->name('factura/pagar_credito');
Route::post('factura/pagar_proveedor', 'FacturaController@pagar_proveedor')->name('factura/pagar_proveedor');


Route::any('canales_servicio', 'FacturaController@canales_servicio')->name('canales_servicio');
Route::any('pedidos_pendientes', 'FacturaController@pedidos_pendientes')->name('pedidos_pendientes');

Route::any('producto/buscar/{id_producto}', 'ProductoController@buscar')->name('producto/buscar');
Route::any('producto/administrar', 'ProductoController@administrar')->name('producto/administrar');
Route::any('producto/crear', 'ProductoController@guardar')->name('producto/crear');
Route::any('producto/editar/{id_producto}', 'ProductoController@guardar')->name('producto/editar');
Route::any('producto/view/{id_producto}', 'ProductoController@view')->name('producto/view');

Route::any('categoria/administrar', 'CategoriaController@administrar')->name('categoria/administrar');
Route::any('categoria/crear', 'CategoriaController@guardar')->name('categoria/crear');
Route::any('categoria/editar/{id_producto}', 'CategoriaController@guardar')->name('categoria/editar');

Route::any('mesa/administrar', 'MesaController@administrar')->name('mesa/administrar');
Route::any('mesa/crear', 'MesaController@guardar')->name('mesa/crear');
Route::any('mesa/editar/{id_mesa}', 'MesaController@guardar')->name('mesa/editar');

Route::any('inventario/movimientos', 'InventarioController@administrar')->name('inventario/movimientos');
Route::any('inventario/crear', 'InventarioController@guardar')->name('inventario/crear');
Route::any('inventario/vista/{id_inventario}', 'InventarioController@vista')->name('inventario/vista');
Route::any('inventario/stock_actual', 'InventarioController@stock_actual')->name('inventario/stock_actual');

Route::any('caja/apertura', 'CajaController@apertura')->name('caja/apertura');
Route::any('caja/view/{id_caja}', 'CajaController@view')->name('caja/view');
Route::any('caja/cerrar/{id_caja}', 'CajaController@cerrar_caja')->name('caja/cerrar');
Route::any('caja/documento/nuevo', 'CajaController@nuevo_documento')->name('caja/documento/nuevo');

Route::any('reportes/facturas', 'ReporteController@facturas')->name('reportes/buscar');
Route::any('reportes/auditoria_interna', 'ReporteController@auditoria_interna')->name('reportes/auditoria_interna');
Route::any('reportes/caja', 'ReporteController@cajas')->name('reportes/caja');
Route::any('reportes/facturas_pendientes_pagar', 'ReporteController@creditos_pendientes')->name('reportes/facturas_pendientes_pagar');
Route::any('reportes/pago-proveedores', 'ReporteController@pago_proveedores')->name('reportes/pago-proveedores');
Route::any('reportes/documentos-asociados-factura/{id_factura}', 'ReporteController@documentos_asociados_factura')->name('reportes/documentos-asociados-factura');

//AGENDA JOBS
Route::any('jobs/agenda/recordatorios', 'AgendaConfiguracionRecordatorioController@job_recordatorios')->name('jobs/agenda/recordatorios');

//AGENDA 
Route::any('clinica/calendario/agendar', 'AgendaController@agendar')->name('clinica/calendario/agendar');
Route::any('clinica/calendario/agendaProfesional', 'AgendaController@agendaProfesional')->name('clinica/calendario/agendaProfesional');
Route::any('clinica/calendario/atender', 'AgendaController@atender')->name('clinica/calendario/atender');
Route::any('clinica/calendario/mostrar/{id}', 'AgendaController@mostrar')->name('clinica/calendario/mostrar');
Route::any('clinica/calendario/cancelar/{id}', 'AgendaController@cancelar')->name('clinica/calendario/cancelar');


//HISTORIA CLINICA
Route::any('clinica/historiaClinica/crear/{id}', 'HistoriaClinicaController@crear')->name('clinica/historiaClinica/crear');
Route::any('clinica/historiaClinica/imprimir_historia/{id_factura}', 'HistoriaClinicaController@imprimir_historia')->name('clinica/historiaClinica/imprimir_historia');

//CONFIGURACION -> AGENDA RECORDATORIO
Route::any('agenda-recordatorio/administrar', 'AgendaConfiguracionRecordatorioController@administrar')->name('agenda-recordatorio/administrar');
Route::any('agenda-recordatorio/crear', 'AgendaConfiguracionRecordatorioController@guardar')->name('agenda-recordatorio/crear');
Route::any('agenda-recordatorio/editar/{id}', 'AgendaConfiguracionRecordatorioController@guardar')->name('agenda-recordatorio/editar');


 
Route::get('factura_email', function () {
    return view('email.factura');
})->name('factura_email');

Route::get('factura_pdf', function () {
    return view('pdf.factura');
})->name('factura_pdf');

Route::get('agenda_email', function () {
    $tercero = (object) [
            "nombres" => "test",
            "apellidos" => "test"
    ];
    $title = "Recordatorio de cita DEMO";
    $subtitulo = "Tu cita empieza en 2 días";
    $imagen_licencia = "https://dakelos.com/imagenes/licencia/logo.jpg";
    $profesional = 1;
    $start       = "2024-09-02 17:00";
    $licencia = (object) [
        "direccion" => "Test",
        "ciudad" => "Test",
        "nombre" => "Test"
    ];
    return view('email.agenda', compact(['tercero', 'title', 'subtitulo', 'imagen_licencia', 'profesional', 'start', 'licencia']));
})->name('agenda_email');


Route::any('licencia/menu_clientes', 'LicenciaController@menu_clientes')->name('licencia/menu_clientes');
Route::any('licencia/validar_pedidos_nuevos', 'LicenciaController@validar_pedidos_nuevos')->name('licencia/validar_pedidos_nuevos');

Route::get('test-cron', function () {
    Log::write("Prueba ejecucion cron", "El cron se ha ejecutado");
    echo "OK";
})->name('test-cron');
