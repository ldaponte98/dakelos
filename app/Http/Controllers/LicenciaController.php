<?php

namespace App\Http\Controllers;

use App\Licencia;
use App\Producto;

class LicenciaController extends Controller
{
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
            return view('sitio.menu', compact(['productos', 'licencia']));
        } else {
            echo "<h1>Direccion no valida</h1>";
        }
    }

    public function menu_clientes()
    {
        $licencia = Licencia::find(session('id_licencia'));
        if ($licencia) {
            return view('licencia.menu_clientes', compact(['licencia']));
        } else {
            echo "<h1>Direccion no valida</h1>";
        }
    }
}
