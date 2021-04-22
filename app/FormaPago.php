<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'forma_pago';
    protected $primaryKey = 'id_forma_pago';


    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }

}
