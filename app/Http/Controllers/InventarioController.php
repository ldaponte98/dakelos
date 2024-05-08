<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Dominio;
use App\Factura;
use App\FormaPago;
use App\FacturaPagoReciboCaja;
use App\Inventario;
use App\InventarioDetalle;
use App\Licencia;
use App\Permiso;
use App\Producto;
use App\ResolucionFactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class InventarioController extends Controller
{
    public function administrar(Request $request)
    {
        $post        = $request->all();
        $fecha_desde = date('Y-m-d') . " 00:00";
        $fecha_hasta = date('Y-m-d') . " 23:59";
        $fechas      = date('Y/m/d') . " 00:00 - " . date('Y/m/d') . " 23:59";
        if ($post) {
            $post   = (object) $post;
            $fechas = $post->fechas;
            if ($fechas != "") {
                $fecha_desde = date('Y-m-d H:i', strtotime(explode('-', $post->fechas)[0]));
                $fecha_hasta = date('Y-m-d H:i', strtotime(explode('-', $post->fechas)[1]));
            }
        }
        $inventarios = Inventario::where('id_licencia', session('id_licencia'))
            ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('inventario.movimientos', compact(['inventarios', 'fechas']));
    }

    public function guardar(Request $request, $id_inventario = null)
    {
        DB::beginTransaction();
        try {
            $post               = $request->all();
            $inventario         = new Inventario;
            $inventario->estado = 1;
            $inventario->fecha  = date('Y-m-d');
            $detalles           = [];
            if ($id_inventario != null) {
                $inventario = Inventario::find($id_inventario);
            }
            $id_dominio_forma_pago_inmediato = null;
            $formas_pago = Dominio::where('id_padre', 19)
                ->get();
            $errors = [];
            if ($post) {
                $post = (object) $post;
                
                $inventario->fill($request->except(['_token']));
                if ($inventario->id_inventario) {
                    $inventario->id_usuario_modifica = session('id_usuario');
                } else {
                    $inventario->id_usuario_registra = session('id_usuario');
                }
                $id_dominio_forma_pago_inmediato = $post->id_dominio_forma_pago_inmediato;
                
                if (isset($post->detalles)) {
                    $detalles                = json_decode($post->detalles);
                    $inventario->id_licencia = session('id_licencia');

                    if ($inventario->save()) {
                        //AHORA REGISTRAMOS LOS DETALLES
                        DB::delete("DELETE FROM inventario_detalle WHERE id_inventario = " . $inventario->id_inventario);
                        $total = 0;
                        foreach ($detalles as $detalle) {
                            $detalle                     = (object) $detalle;
                            $producto                    = Producto::find($detalle->id);
                            $item                        = new InventarioDetalle;
                            $item->id_inventario         = $inventario->id_inventario;
                            $item->id_producto           = $producto->id_producto;
                            $item->nombre_producto       = strtoupper($producto->nombre);
                            $item->precio_producto       = $detalle->precio;
                            $item->presentacion_producto = $producto->presentacion->nombre;
                            $item->cantidad              = $detalle->cantidad;
                            if ($item->save()) {
                                $total += $item->cantidad * $item->precio_producto;
                                //AHORA DESCONTAMOS O SUMAMOS A LA CANTIDAD ACTUAL DEL PRODUCTO
                                if ($inventario->id_dominio_tipo_movimiento == Dominio::get('Entrada de inventario')) {
                                    //ENTRADA
                                    $producto->cantidad_actual += $detalle->cantidad;
                                }

                                if ($inventario->id_dominio_tipo_movimiento == Dominio::get('Salida de inventario')) {
                                    //SALIDA
                                    $producto->cantidad_actual -= $detalle->cantidad;
                                }
                                $producto->save();
                            }
                        }

                        //SI ES UNA ENTRADA DE INVENTARIO SE REGISTRA UN COMPROBANTE DE EGRESO A NOMBRE DE LA EMPRESA
                        if ($post->id_dominio_tipo_movimiento == Dominio::get("Entrada de inventario")) {
                            //CREAMOS FACTURA DE COMPROBANTE DE EGRESO
                            $licencia   = Licencia::find(session('id_licencia'));
                            $id_tercero = isset($post->id_tercero_proveedor) && $post->id_tercero_proveedor != "" && $post->id_tercero_proveedor != null ? 
                                $post->id_tercero_proveedor : 
                                $licencia->id_tercero_responsable;
                            $facturacion = $this->facturar_entrada_inventario($id_tercero, $total, $detalles, $inventario, $post);
                            if (!$facturacion->error) {
                                $inventario->id_factura = $facturacion->id_factura;
                                $inventario->save();
                            } else {
                                throw new Exception($facturacion->message);
                            }
                        }
                        DB::commit();
                        return redirect()->route('inventario/vista', $inventario->id_inventario);
                    } else {
                        $errors = $inventario->errors;
                        throw new Exception("Ocurrio un error registrando el inventario");
                    }
                } else {
                    throw new Exception("Debe escoger por lo menos un producto para el movimiento de inventario.");
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            $errors[] = $e->getMessage();
        }
        return view('inventario.form', compact(['inventario', 'detalles', 'formas_pago', 'errors', 'id_dominio_forma_pago_inmediato']));
    }

    public function vista($id_inventario)
    {
        $inventario = Inventario::find($id_inventario);
        if ($inventario) {
            return view('inventario.view', compact(['inventario']));
        }
        echo "Url invalida";
    }

    public function stock_actual()
    {
        $tipos = Dominio::all()->where('id_padre', 35)->where('id_dominio', '<>', 37);
        return view('inventario.stock_actual', compact('tipos'));
    }

    public function facturar_entrada_inventario($id_tercero, $valor = 0, $detalles = [], $inventario, $post)
    {
        $error      = true;
        $message    = "";
        $id_factura = null;
        $resolucion = ResolucionFactura::where('id_licencia', session('id_licencia'))->first();

        $caja = Caja::where('id_usuario', session('id_usuario'))
            ->where('estado', 1)
            ->where('fecha_cierre', null)
            ->first();

        if ($caja == null) {
            if (Permiso::validar(3)) {
                $caja = Caja::where('id_licencia', session('id_licencia'))
                    ->where('estado', 1)
                    ->where('fecha_cierre', null)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }
        }

        if ($resolucion) {
            //RESOLUCION DEL DOCUMENTO
            $factura         = new Factura;
            $factura->numero = $resolucion->prefijo_comprobante_egreso . "-" . ($resolucion->consecutivo_comprobante_egreso + 1);

            if ($caja) {
                $factura->id_tercero                 = $id_tercero;
                $factura->id_caja                    = $caja->id_caja;
                $factura->valor                      = $valor;
                $factura->valor_original             = $valor;
                $factura->id_dominio_tipo_factura    = Dominio::get("Comprobante de egreso");
                $factura->observaciones              = "Entrada de inventario";
                $factura->id_usuario_registra        = session('id_usuario');
                $factura->id_licencia                = session('id_licencia');
                $factura->id_dominio_canal           = 49;
                $factura->finalizada                 = 1;
                if($inventario->tipo_pago == "Credito"){
                    $factura->credito_comprobante_egreso = 1;
                    $factura->abono_inicial = $inventario->abono_inicial;
                    $factura->id_dominio_forma_pago_abono_inicial = $inventario->id_dominio_forma_pago_abono;
                    $factura->valor = $valor - $inventario->abono_inicial;
                    $factura->pagada = 0;
                }
                if ($factura->save()) {
                    $resolucion->consecutivo_comprobante_egreso += 1;
                    $resolucion->save();

                    if($inventario->tipo_pago == "Inmediato" && $post->id_dominio_forma_pago_inmediato != "ahorro"){
                        $forma_pago = new FormaPago;
                        $forma_pago->id_factura = $factura->id_factura;
                        $forma_pago->id_dominio_forma_pago = $post->id_dominio_forma_pago_inmediato;
                        $forma_pago->valor = $factura->valor * -1;
                        $forma_pago->save();
                    }
                    $id_factura = $factura->id_factura;
                    $error      = false;
                } else {
                    $message = $factura->errors[0];
                }
            } else {
                $message = "No existe caja abierta para este usuario activa";
            }
        } else {
            $message = "No tiene resolución de factura activa";
        }

        return (object) [
            'error'      => $error,
            'message'    => $message,
            'id_factura' => $id_factura,
        ];
    }

}
