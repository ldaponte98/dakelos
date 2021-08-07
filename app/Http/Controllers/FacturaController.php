<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Factura;
use App\FacturaDetalle;
use App\FormaPago;
use App\Licencia;
use App\Producto;
use App\ResolucionFactura;
use App\Tercero;
use Illuminate\Http\Request;
use Mail;

class FacturaController extends Controller
{
    public function crear(Request $request)
    {
        $post    = (object) $request->all();
        $tercero = new Tercero;
        $accion  = "Facturación";
        $tipo    = $post->tipo;
        if ($tipo == 17) {
            $accion = "Cotización";
        }

        if ($post->id_tercero) {
            $tercero = Tercero::find($post->id_tercero);
        }

        return view('factura.form', compact([
            'tercero', 'accion', 'tipo',
        ]));
    }

    public function finalizar_factura(Request $request)
    {
        $post       = $request->all();
        $error      = true;
        $mensaje    = "";
        $id_factura = null;
        $errors     = [];
        if ($post) {
            $post = (object) $post;
            //primero buscamos el consecutivo de la resolucion para la factura
            $resolucion = ResolucionFactura::where('id_licencia', session('id_licencia'))->first();

            if ($resolucion) {
                $factura = new Factura;
                if ($post->tipo_factura == 16) {
                    $factura->numero = $resolucion->prefijo_factura . "-" . ($resolucion->consecutivo_factura + 1);
                }

                if ($post->tipo_factura == 17) {
                    $factura->numero = $resolucion->prefijo_cotizacion . "-" . ($resolucion->consecutivo_cotizacion + 1);
                }

                $factura->id_tercero              = $post->id_tercero;
                $factura->valor                   = $post->total_carrito;
                $factura->id_dominio_tipo_factura = $post->tipo_factura;
                $factura->observaciones           = $post->observaciones;
                $factura->id_usuario_registra     = session('id_usuario');
                $factura->id_licencia             = session('id_licencia');

                if ($factura->save()) {
                    //ahora aumentamos el consecutivo de la resolucion
                    if ($post->tipo_factura == 16) {
                        $resolucion->consecutivo_factura += 1;
                    }

                    if ($post->tipo_factura == 17) {
                        $resolucion->consecutivo_cotizacion += 1;
                    }

                    $resolucion->save();

                    //ahora registramos los detalles de la factura
                    foreach ($post->carrito as $producto) {
                        $producto                      = (object) $producto;
                        $detalle                       = new FacturaDetalle;
                        $detalle->id_factura           = $factura->id_factura;
                        $detalle->id_producto          = $producto->id_producto;
                        $detalle->iva_producto         = $producto->iva;
                        $detalle->nombre_producto      = $producto->nombre;
                        $detalle->descripcion_producto = $producto->descripcion;
                        $detalle->precio_producto      = $producto->precio;
                        $detalle->descuento_producto   = $producto->descuento;
                        $detalle->save();
                    }

                    //Ahora registramos las formas de pago
                    if (isset($post->formas_pago)) {
                        foreach ($post->formas_pago as $forma) {
                            $forma                             = (object) $forma;
                            $forma_pago                        = new FormaPago;
                            $forma_pago->id_factura            = $factura->id_factura;
                            $forma_pago->id_dominio_forma_pago = $forma->id_dominio_forma_pago;
                            $forma_pago->valor                 = $forma->valor;
                            $forma_pago->save();
                        }
                    }

                    $tercero = Tercero::find($factura->id_tercero);
                    //ahora enviamos email con la factura al cliente
                    $subject = $factura->tipo->nombre . ' ' . $factura->licencia->nombre;
                    $for     = $tercero->email;

                    $data_email = array(
                        'factura'         => $factura,
                        'imagen_licencia' => $factura->licencia->get_imagen_email(),
                        'tipo_factura'    => $factura->tipo->nombre,
                        'id_factura'      => $factura->id_factura,
                    );

                    Mail::send('email.factura', $data_email, function ($msj) use ($subject, $for) {
                        $msj->from(config('global.email_zorax'), session('nombre_licencia'));
                        $msj->subject($subject);
                        $msj->to($for);
                    });
                    $error      = false;
                    $id_factura = $factura->id_factura;
                    $mensaje    = "Documento registrado exitosamente";
                } else {
                    $mensaje = "Error al registrar la factura";
                    $errors  = $factura->errors;
                }
            } else {
                $mensaje = "No tiene resolucion activa";
            }

            return response()->json([
                'error'      => $error,
                'mensaje'    => $mensaje,
                'errors'     => $errors,
                'id_factura' => $id_factura,
            ]);
        }
    }

    public function imprimir($id_factura)
    {
        $factura = Factura::find($id_factura);
        $pdf     = \PDF::loadView('pdf.factura', compact('factura'));
        return $pdf->stream($factura->tipo->nombre . ' ' . $factura->licencia->nombre . '.pdf');
    }

    public function facturador(Request $request)
    {
        $categorias = Categoria::where('estado', 1)
            ->where('id_licencia', session('id_licencia'))
            ->orderBy('nombre', 'desc')
            ->get();

        $productos = Producto::where('estado', 1)
            ->where('id_licencia', session('id_licencia'))
            ->orderBy('nombre', 'desc')
            ->get();
        return view("factura.facturador", compact(['categorias', 'productos']));
    }
}
