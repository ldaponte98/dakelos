<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table      = 'inventario';
    protected $primaryKey = 'id_inventario';

    public function detalles()
    {
        return $this->hasMany(InventarioDetalle::class, 'id_inventario');
    }

    public function usuario_registra()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registra', 'id_usuario');
    }

    public function usuario_modifica()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_modifica', 'id_usuario');
    }

    public function tipo_movimiento()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_tipo_movimiento');
    }
}
