<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table      = 'factura';
    protected $primaryKey = 'id_factura';

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }

    public function tercero()
    {
        return $this->belongsTo(Tercero::class, 'id_tercero');
    }

    public function usuario_registra()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registra');
    }

    public function tipo()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_tipo_factura');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'id_mesa');
    }

    public function canal()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_canal');
    }

    public function detalles()
    {
        return $this->hasMany(FacturaDetalle::class, 'id_factura');
    }

    public function formas_pago()
    {
        return $this->hasMany(FormaPago::class, 'id_factura');
    }

    public function get_estado()
    {
        switch ($this->estado) {
            case 1:
                return "Activa";

            case 0:
                return "Anulada";

            default:
                return "Indefinido";
                break;
        }
    }

    public function get_formas_pago()
    {
        $items = [];
        foreach ($this->formas_pago as $item) {
            $items[] = $item->id_dominio_forma_pago;
        }
        return $items;
    }
}
