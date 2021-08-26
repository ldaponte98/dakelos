<?php

namespace App\Http\Controllers;

use App\Inventario;
use App\InventarioDetalle;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function administrar(Request $request)
    {
        $post        = (object) $request->all();
        $inventarios = Inventario::all()->where('id_licencia', session('id_licencia'));
        return view('inventario.movimientos', compact('inventarios'));
    }

    public function guardar(Request $request, $id_inventario = null)
    {
        $post               = $request->all();
        $inventario         = new Inventario;
        $inventario->estado = 1;
        $inventario->fecha  = date('Y-m-d');
        $detalles           = [];
        if ($id_inventario != null) {
            $inventario = Inventario::find($id_inventario);
        }

        $errors = [];
        if ($post) {
            DB::beginTransaction();
            $post = (object) $post;
            $inventario->fill($request->except(['_token']));
            if ($inventario->id_inventario) {
                $inventario->id_usuario_modifica = session('id_usuario');
            } else {
                $inventario->id_usuario_registra = session('id_usuario');
            }

            if (isset($post->detalles)) {

                $detalles                = json_decode($post->detalles);
                $inventario->id_licencia = session('id_licencia');

                if ($inventario->save()) {
                    //AHORA REGISTRAMOS LOS DETALLES
                    DB::delete("DELETE FROM inventario_DETALLE WHERE id_inventario = " . $inventario->id_inventario);
                    foreach ($detalles as $detalle) {
                        $detalle                     = (object) $detalle;
                        $producto                    = Producto::find($detalle->id);
                        $item                        = new InventarioDetalle;
                        $item->id_inventario         = $inventario->id_inventario;
                        $item->id_producto           = $producto->id_producto;
                        $item->nombre_producto       = strtoupper($producto->nombre);
                        $item->precio_producto       = $producto->precio_compra;
                        $item->presentacion_producto = $producto->presentacion->nombre;
                        $item->cantidad              = $detalle->cantidad;
                        if ($item->save()) {
                            //AHORA DESCONTAMOS O SUMAMOS A LA CANTIDAD ACTUAL DEL PRODUCTO
                            if ($inventario->id_dominio_tipo_movimiento == 40) {
                                //ENTRADA
                                $producto->cantidad_actual += $detalle->cantidad;
                            }

                            if ($inventario->id_dominio_tipo_movimiento == 41) {
                                //SALIDA
                                $producto->cantidad_actual -= $detalle->cantidad;
                            }
                            $producto->save();
                        }
                    }
                    DB::commit();
                    return redirect()->route('inventario/vista', $inventario->id_inventario);
                } else {
                    DB::rollBack();
                    $errors = $inventario->errors;
                }
            } else {
                DB::rollBack();
                $errors[] = "Debe escoger por lo menos un producto para el movimiento de inventario.";
                return view('inventario.form', compact(['inventario', 'detalles', 'errors']));
            }
        }
        return view('inventario.form', compact(['inventario', 'detalles', 'errors']));
    }

    public function vista($id_inventario)
    {
        $inventario = Inventario::find($id_inventario);
        if ($inventario) {
            return view('inventario.view', compact(['inventario']));
        }
        echo "Url invalida";
    }

}
