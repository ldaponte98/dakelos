<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $facturas = Factura::where('estado', 1)
                    ->where('id_caja', $this->id_caja)
                    ->where('finalizada', 1)
                    ->get();
        $total = $this->valor_inicial;
        foreach ($facturas as $factura) {
            if($factura->id_dominio_tipo_factura <> 17 && 
            $factura->id_dominio_tipo_factura <> 53 &&
            $factura->id_dominio_tipo_factura <> 56 &&
            $factura->pagada == 1) $total += $factura->valor_original;

            if($factura->id_dominio_tipo_factura == 56 &&
            $factura->pagada == 1) $total += $factura->abono_inicial;

            if($factura->id_dominio_tipo_factura == 53 && 
            $factura->credito_comprobante_egreso == 0) $total -= $factura->valor_original;

            if($factura->id_dominio_tipo_factura == 53 && 
            $factura->credito_comprobante_egreso == 1) $total -= $factura->abono_inicial;

            $total -= $factura->total_donde_han_usado_ahorro();
        }            
        return $total;
    }

    public function get_descuentos()
    {
        return Factura::where('estado', 1)
            ->where('id_caja', $this->id_caja)
            ->where('id_dominio_tipo_factura', '<>', 17)
            ->where('finalizada', 1)
            ->sum('descuento');
    }

    public function get_egresos()
    {
        return Factura::where('estado', 1)
            ->where('id_caja', $this->id_caja)
            ->where('id_dominio_tipo_factura', 53)
            ->where('finalizada', 1)
            ->sum('valor_original');
    }

    public function get_egresos_a_credito()
    {
        $facturas = Factura::where('estado', 1)
        ->where('id_caja', $this->id_caja)
        ->where('id_dominio_tipo_factura', 53)
        ->where('credito_comprobante_egreso', 1)
        ->get();
        $total = 0;
        foreach ($facturas as $item) {
            $total += $item->valor_original - $item->abono_inicial;
        }
        return $total;
    }

    public function get_egresos_inmediatos()
    {
        return Factura::where('estado', 1)
            ->where('id_caja', $this->id_caja)
            ->where('id_dominio_tipo_factura', 53)
            ->where('credito_comprobante_egreso', 0)
            ->sum('valor_original');
    }

    public function get_abonos_egresos_a_credito()
    {
        return Factura::where('estado', 1)
            ->where('id_caja', $this->id_caja)
            ->where('id_dominio_tipo_factura', 53)
            ->where('credito_comprobante_egreso', 1)
            ->sum('abono_inicial');
    }

    public function total_por_canal($id_dominio_canal)
    {
        return Factura::where('estado', 1)
            ->where('id_caja', $this->id_caja)
            ->where('id_dominio_tipo_factura', '<>', 17)
            ->where('id_dominio_canal', $id_dominio_canal)
            ->where('finalizada', 1)
            ->sum('valor_original');
    }

    public function total_por_forma_pago($id_dominio_forma_pago)
    {
        echo "<script>console.log({forma:$id_dominio_forma_pago})</script>";
        return DB::table('factura as f')
            ->join('forma_pago as fp', 'fp.id_factura', '=', 'f.id_factura')
            ->where('f.estado', 1)
            ->where('f.id_caja', $this->id_caja)
            ->where('f.id_dominio_tipo_factura', '<>', 17)
            ->where('fp.id_dominio_forma_pago', $id_dominio_forma_pago)
            ->where('f.finalizada', 1)
            ->sum('fp.valor');
    }
}
