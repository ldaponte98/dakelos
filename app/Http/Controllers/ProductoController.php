<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function buscar($id_producto)
    {
    	return response()->json(Producto::find($id_producto));
    }

    public function administrar(Request $request)
    {
    	$post = (object) $request->all();
        $productos = Producto::all()->where('id_licencia', session('id_licencia'));
        if($post){

        }
        return view('producto.administrar', compact('productos'));
    }

    public function crear(Request $request, $id_producto = null)
    {
    	$post = $request->all();
    	$producto = new Producto;
        $producto->estado = null;
        $producto->precio_venta = 0;
        $producto->precio_compra = 0;
        $producto->iva = 0;
        $producto->descontado = 0;
        $producto->contenido = 1;
        $producto->cantidad_actual = 0;
        $producto->cantidad_minimo_alerta = 0;
    	if($id_producto != null) $producto = Producto::find($id_producto);
    	$errors = [];
    	if($post){
            $post = (object) $post;
            
            $producto->fill($request->except(['_token', 'imagen']));
            $producto->id_usuario_registra = session('id_usuario');
            $producto_nombre = Producto::where('nombre', $post->nombre)
                                               ->where('id_licencia', session('id_licencia'))
                                               ->where('id_producto','<>',$id_producto)
                                               ->first();
            if(isset($post->descontado)){
            	$producto->descontado = 1;
            	
            }else{
            	$producto->contenido = 1;
        		$producto->cantidad_actual = 0;
        		$producto->cantidad_minimo_alerta = 0;
            	$producto->descontado = 0;
            }

            if(!$producto_nombre){
                $producto->id_licencia = session('id_licencia');
                $file = $request->file('imagen');
                if ($file) {
                   $ruta = '/imagenes/producto';
                   $extension = explode('.', $file->getClientOriginalName())[1];
                   $nombre_archivo = rand(1000, 999999)."-".date('Y-m-d-H-i-s').".".$extension;
                   Storage::disk('public')->put($ruta."/".$nombre_archivo,  \File::get($file));
                   $producto->imagen = $nombre_archivo;
                }
                if ($producto->save()) {
                    return redirect()->route('producto/view', $producto->id_producto);
                }else{
                    $errors = $producto->errors;
                }
            }else{
                $errors[] = "El nombre de estre producto ya esta registrado.";
                return view('producto.form',compact(['producto', 'errors']));
            }
    	}
        return view('producto.form',compact(['producto', 'errors']));
    	
    }

    public function view($id_producto)
    {
    	$producto = Producto::find($id_producto);
    	if($producto){
    		return view('producto.view', compact(['producto']));
    	}
    	echo "Acceso denegado";
    }
}
