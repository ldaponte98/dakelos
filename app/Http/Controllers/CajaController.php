<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Dominio;
use App\Factura;
use App\FormaPago;
use App\ResolucionFactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    public function apertura(Request $request)
    {
        $post    = $request->all();
        $errores = [];
        if ($post) {
            $post                 = (object) $post;
            $caja                 = new Caja;
            $caja->id_usuario     = session('id_usuario');
            $caja->fecha_apertura = date('Y-m-d H:i:s');
            $caja->valor_inicial  = 0;
            $caja->id_licencia    = session('id_licencia');
            if ($post->tipo_apertura == "apertura_0") {
                $caja->save();
                return redirect()->route('caja/view', $caja->id_caja);
            }

            if ($post->tipo_apertura == "apertura_valor") {
                if ($post->valor_inicial >= 0) {
                    $caja->valor_inicial = $post->valor_inicial;
                    $caja->save();
                    return redirect()->route('caja/view', $caja->id_caja);
                } else {
                    $errores[] = "El valor inicial de la caja no es valido";
                }
            }
        }
        return view("caja.apertura", compact(["errores"]));
    }

    public function view($id_caja)
    {
        $caja = Caja::where('id_caja', $id_caja)->where('id_licencia', session('id_licencia'))->first();
        if ($caja) {
            $canales     = Dominio::get_canales(session('id_licencia'));
            $formas_pago = Dominio::where('id_padre', 19)
                ->get();
            return view('caja.view', compact(['caja', 'canales', 'formas_pago']));
        }
        echo "Direccion no valida";die;
    }

    public function cerrar_caja($id_caja)
    {
        $error   = true;
        $mensaje = "";
        $caja    = Caja::find($id_caja);
        if ($caja) {
            if ($caja->id_usuario == session('id_usuario')) {
                $caja->fecha_cierre = date('Y-m-d H:i:s');
                $caja->save();
                $error   = false;
                $mensaje = "Caja cerrada exitosamente";
            } else {
                $mensaje = "La caja no puede ser cerrada por otro usuario distinto al que la abre";
            }
        } else {
            $mensaje = "Caja no valida";
        }
        return response()->json([
            'error'   => $error,
            'mensaje' => $mensaje,
        ]);
    }

    public function nuevo_documento(Request $request)
    {
        $post    = $request->all();
        $factura = new Factura;
        $errors  = [];
        $formas_pago = Dominio::where('id_padre', Dominio::get('Formas de pago'))
            ->where('id_dominio', '<>', Dominio::get('Credito (Saldo pendiente)'))
            ->get();
        if ($post) {
            $post = (object) $post;
            $resolucion = ResolucionFactura::where('id_licencia', session('id_licencia'))->first();
            if ($resolucion) {
                DB::beginTransaction();
                //RESOLUCION DEL DOCUMENTO
                if ($post->id_dominio_tipo_factura == Dominio::get("Comprobante de egreso")) {
                    $factura->numero = $resolucion->prefijo_comprobante_egreso . "-" . ($resolucion->consecutivo_comprobante_egreso + 1);
                }

                if ($post->id_dominio_tipo_factura == Dominio::get("Recibo de caja")) {
                    $factura->numero = $resolucion->prefijo_recibo_caja . "-" . ($resolucion->consecutivo_recibo_caja + 1);
                }

                if ($post->id_dominio_tipo_factura == Dominio::get("Factura a credito (Saldo pendiente)")) {
                    $factura->numero = $resolucion->prefijo_credito . "-" . ($resolucion->consecutivo_credito + 1);
                }

                $caja = Caja::where('id_usuario', session('id_usuario'))
                    ->where('estado', 1)
                    ->where('fecha_cierre', null)
                    ->first();

                if ($caja) {
                    $factura->id_tercero              = $post->id_tercero;
                    $factura->id_caja                 = $caja->id_caja;
                    $factura->valor                   = $post->valor;
                    $factura->valor_original          = $post->valor;
                    $factura->id_dominio_tipo_factura = $post->id_dominio_tipo_factura;
                    $factura->observaciones           = $post->observaciones;
                    $factura->descripciones           = $post->descripciones;
                    $factura->id_usuario_registra     = session('id_usuario');
                    $factura->id_licencia             = session('id_licencia');
                    $factura->id_dominio_canal        = 49;
                    $factura->finalizada              = 1;
                    if ($factura->save()) {
                        $forma_pago                        = new FormaPago;
                        $forma_pago->id_factura            = $factura->id_factura;
                        if($post->id_dominio_tipo_factura == Dominio::get("Factura a credito (Saldo pendiente)")){
                            $forma_pago->id_dominio_forma_pago = Dominio::get("Credito (Saldo pendiente)");
                            //VALIDAMOS SI ESE CREDITO SALIO DE LA CAJA ACTUAL Y SE DEBE DESCONTAR, POR ENDE SE DEBE CREAR UN COMPROBANTE DE EGRESO
                            if($post->acciones_caja == "descontar"){
                                $id_egreso = $this->generar_retiro_caja_credito($factura, $caja, $resolucion, $post->forma_pago);
                                $factura->id_factura_cruce = $id_egreso;
                                $factura->save();
                            }
                        }else{
                            $forma_pago->id_dominio_forma_pago = $post->forma_pago;
                        }
                        $forma_pago->valor                 = $post->valor;
                        $forma_pago->save();

                        if ($post->id_dominio_tipo_factura == Dominio::get("Comprobante de egreso")) {
                            $resolucion->consecutivo_comprobante_egreso += 1;
                        }
                        if ($post->id_dominio_tipo_factura == Dominio::get("Recibo de caja")) {
                            $resolucion->consecutivo_recibo_caja += 1;
                        }
                        if ($post->id_dominio_tipo_factura == Dominio::get("Factura a credito (Saldo pendiente)")) {
                            $resolucion->consecutivo_credito += 1;
                        }
                        $resolucion->save();
                        DB::commit();
                        return redirect()->route('caja/view', $caja->id_caja);
                    } else {
                        DB::rollBack();
                        $errors = $factura->errors;
                    }
                } else {
                    DB::rollBack();
                    $errors[] = "No existe caja abierta para este usuario activa";
                }
            } else {
                DB::rollBack();
                $errors[] = "No tiene resolución de factura activa";
            }
        }
        return view('caja.nuevo_documento', compact(['factura', 'formas_pago','errors']));
    }

    public function generar_retiro_caja_credito($factura, $caja, $resolucion, $id_dominio_forma_pago)
    {
        $documento = new Factura;
        $documento->numero = $resolucion->prefijo_comprobante_egreso . "-" . ($resolucion->consecutivo_comprobante_egreso + 1);
        
        DB::beginTransaction();
        $documento->id_tercero                 = $factura->id_tercero;
        $documento->id_caja                    = $caja->id_caja;
        $documento->valor_original             = $factura->valor_original;
        $documento->valor                      = 0;
        $documento->id_dominio_tipo_factura    = Dominio::get("Comprobante de egreso");
        $documento->descripciones              = $factura->descripciones;
        $documento->observaciones              = $factura->observaciones;
        $documento->id_usuario_registra        = session('id_usuario');
        $documento->id_licencia                = session('id_licencia');
        $documento->id_dominio_canal           = Dominio::get('No definido');
        $documento->finalizada                 = 1;
        $documento->pagada                     = 1;
        if ($documento->save()) {
            $resolucion->consecutivo_comprobante_egreso += 1;
            $resolucion->save();

            $forma_pago                        = new FormaPago;
            $forma_pago->id_factura            = $documento->id_factura;
            $forma_pago->id_dominio_forma_pago = $id_dominio_forma_pago;
            $forma_pago->valor                 = $documento->valor;
            $forma_pago->save();
            DB::commit();
            return $documento->id_factura;
        } else {
            DB::rollBack();
        }
        return null;
    }
}
