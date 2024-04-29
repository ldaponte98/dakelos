<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table      = 'permiso';
    protected $primaryKey = 'id_permiso';

    public static function get($name)
    {
        $result = Permiso::where("nombre", $name)->first();
        return $result == null ? 0 : $result->id_permiso;
    }

    public static function validar($id_permiso, $id_perfil = null)
    {
        $id_perfil = $id_perfil == null ? session('id_perfil') : $id_perfil;
        $id_licencia = session('id_licencia');
        $busqueda  = PerfilPermiso::where('estado', 1)
            ->where('id_permiso', $id_permiso)
            ->where('id_perfil', $id_perfil)
            ->first();
        
        $valido = false;
        if($busqueda != null){
            if($busqueda->id_licencias == "" || $busqueda->id_licencias == null){
                $valido = true;
            }else{
                $id_licencias = explode(",", $busqueda->id_licencias);
                foreach ($id_licencias as $id) {
                    if($id == $id_licencia) $valido = true;
                }
            }
        }
        return $valido;
    }
}
