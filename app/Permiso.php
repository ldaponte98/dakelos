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
        $busqueda  = PerfilPermiso::where('estado', 1)
            ->where('id_permiso', $id_permiso)
            ->where('id_perfil', $id_perfil)
            ->first();
        return $busqueda ? true : false;
    }
}
