<?php

namespace App\Http\Controllers;

use App\Caja;
use Illuminate\Http\Request;

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
        $caja = Caja::find($id_caja);
        if ($caja) {
            return view('caja.view', compact(["caja"]));
        }
        echo "Direccion no valida";die;
    }
}
