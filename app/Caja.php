<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table      = 'caja';
    protected $primaryKey = 'id_caja';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function get_total()
    {
        return Factura::where('estado', 1)->where('id_caja', $this->id_caja)->sum('valor');
    }
}
