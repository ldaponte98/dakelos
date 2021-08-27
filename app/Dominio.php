<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dominio extends Model
{
    protected $table      = 'dominio';
    protected $primaryKey = 'id_dominio';

    public static function get($name)
    {
        $dominio = Dominio::where('nombre', $name)->first();
        return $dominio ? $dominio->id_dominio : null;
    }
}
