<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaPagoReciboCaja extends Model
{
    protected $table = 'factura_pago_recibo_caja';

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

    public function recibo_caja()
    {
        return $this->belongsTo(Factura::class, 'id_factura_recibo_caja', 'id_factura');
    }
}

