<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Tercero;

class UsuarioController extends Controller
{
    public function auth(Request $request)
    {	
    	
    	 $post = $request->all();
    	 if($post){
    	 	$post = (object) $post;
    	 	$usuario = Usuario::where('usuario', $post->usuario)
                                ->where('estado', 1)
                                ->first();

    	 	if ($usuario) {
    	 		$clave = md5($post->clave);
    	 		    	 	
    	 		if (trim($usuario->clave) == trim($clave)) {

                    //aca el tercero existe pero hay que mirar el estado
                    if($usuario->tercero->estado == 0) return back()->withErrors(['error'=>'Acceso denegado']);
	    			session([
	                'id_usuario' => $usuario->id_usuario,
	                'id_tercero_usuario' =>  $usuario->tercero->id_tercero,
                    'id_licencia' => $usuario->tercero->id_licencia,
                    'nombre_licencia' => $usuario->tercero->licencia->nombre,
	                'id_perfil' => $usuario->id_perfil
	    			]);
	                return redirect()->route('index');
	    	 	}
	    	 	return back()->withErrors(['error'=>'Credenciales invalidas']);
    	 	}else{
		    	return back()->withErrors(['error'=>'Credenciales invalidas']);
    	 	}
    	 	
    	 }
    }

	public function logout(Request $request)
    {
        $request->session()->flush();
         return redirect('/');
    }

    public function index()
    {
    	return view('sitio.index');
    }
}
