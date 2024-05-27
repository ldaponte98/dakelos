<?php

namespace App\Http\Controllers;

use App\Licencia;
use App\Categoria;
use App\ProductoCategoria;
use App\Producto;

class AppController extends Controller
{
    public function resolve($error = true, $message = "", $data = null, $http_code = 200) {
        return response()->json((object)[
            "error" => $error,
            "message" => $message,
            "data" => $data
        ], $http_code);
    }
    public function menu($token)
    {
        $licencia = Licencia::where('token', $token)->first();
        if ($licencia) {
            //$_categorias = Categoria::all()->where('estado', 1)->where('id_licencia', $licencia->id_licencia);
            $categorias = [];
            $productos  = Producto::where('estado', 1)
                ->where('id_licencia', $licencia->id_licencia)
                ->where('id_dominio_tipo_producto', 36)
                ->orderBy('nombre', 'asc')
                ->get();
            /*foreach ($_categorias as $categoria) {
            $data['id_categoria']     = $categoria->id_categoria;
            $data['nombre_categoria'] = $categoria->nombre;

            }*/
            return view('app.layout', compact(['productos', 'licencia']));
        } else {
            echo "<h1>Direccion no valida</h1>";
        }
    }

    public function validar_app_name($app_name) {
        $licencia = Licencia::where('nombre_app', $app_name)->first();
        if($licencia == null) return $this->resolve(true, "Aplicacion no valida", null, 400);
        return $this->resolve(false, "Aplicacion valida", $licencia);
    }

    public function productos($app_name)
    {
        $licencia = Licencia::where('nombre_app', $app_name)->first();
        if($licencia == null) return $this->resolve(true, "Aplicacion no valida");

        $categorias = Categoria::where('estado', 1)
                               ->where('id_licencia', $licencia->id_licencia)
                               ->get();
        $response = [];
        foreach ($categorias as $categoria) {
            $relacion_productos = ProductoCategoria::where('id_categoria', $categoria->id_categoria)
            ->get();
            $item = (object) [
                'id' => $categoria->id_categoria,
                'nombre' => $categoria->nombre,
                'path_imagens' => env('APP_URL') . "/imagenes/producto",
                'productos' => []
            ];
            foreach ($relacion_productos as $relacion) {
                $producto = $relacion->producto;
                if($producto->estado == 1  && 
                $producto->visible_app == 1 && 
                $producto->id_dominio_tipo_producto == 36){
                    $item->productos[] = (object) [
                        'id' => $producto->id_producto,
                        'nombre' => $producto->nombre,
                        'descripcion' => $producto->descripcion,
                        'precio' => $producto->precio_venta,
                        'presentacion' => $producto->presentacion->nombre,
                        'imagen' => $producto->imagen
                    ];
                }
            }
            $response[] = $item;
        }
        return $response;
    }

}
