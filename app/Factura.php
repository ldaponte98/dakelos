<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class Factura extends Model
{
    protected $table      = 'factura';
    protected $primaryKey = 'id_factura';

    protected $fillable = [
        'id_tercero',
        'id_dominio_tipo_factura',
        'numero',
        'valor',
        'id_caja',
    ];

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }

    public function cruce()
    {
        return $this->belongsTo(Factura::class, 'id_factura_cruce', 'id_factura');
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

    public function pago_con_ahorros()
    {
        return $this->hasMany(FacturaPagoReciboCaja::class, 'id_factura');
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

    public function estaPagada()
    {
        $facturas_abonos = Factura::where('id_factura_cruce', $this->id_factura)->get();
        $pagada = false;
        $total_abono = 0;
        foreach ($facturas_abonos as $factura_abono) {
            $total_abono += $factura_abono->valor;
        }
        $pagada = $total_abono == $this->valor_original;
        return $pagada;
    }

    public function getTotalAbonos()
    {
        $facturas_abonos = Factura::where('id_factura_cruce', $this->id_factura)->get();
        $total_abono = 0;
        foreach ($facturas_abonos as $factura_abono) {
            $total_abono += $factura_abono->valor;
        }
        return $total_abono;
    }

    public function formas_pago_recibos_caja()
    {
        $result = FacturaPagoReciboCaja::where('id_factura', $this->id_factura)->get();
        return $result;
    }

    public function facturas_donde_han_usado_ahorro()
    {
        $result = FacturaPagoReciboCaja::where('id_factura_recibo_caja', $this->id_factura)->get();
        $facturas = [];
        foreach ($result as $value) {
            $facturas[] = $value->factura;
        }
        return $facturas;
    }

    public function total_donde_han_usado_ahorro()
    {
        $result = FacturaPagoReciboCaja::where('id_factura_recibo_caja', $this->id_factura)->get();
        $total = 0;
        foreach ($result as $value) {
            if($value->factura->finalizada == 1) $total += $value->valor;
        }
        return $total;
    }

    public function enviar_email()
    {
        $mensaje = "";
        $error   = true;
        $factura = $this;
        $tercero = Tercero::find($factura->id_tercero);
        //ahora enviamos email con la factura al cliente
        $subject = $factura->tipo->nombre . ' ' . $factura->licencia->nombre;
        $for     = $tercero->email;
        if($for != null && $for != ""){
            $data_email = array(
                'factura'         => $factura,
                'imagen_licencia' => $factura->licencia->get_imagen_email(),
                'tipo_factura'    => $factura->tipo->nombre,
                'id_factura'      => $factura->id_factura,
            );
            if ($for) {
                try {
                    Mail::send('email.factura', $data_email, function ($msj) use ($subject, $for) {
                        $msj->from(config('global.email_app'), session('nombre_licencia'));
                        $msj->subject($subject);
                        $msj->to($for);
                    });
                    $error   = false;
                    $mensaje = "OK";
                } catch (Exception $e) {
                    $mensaje = "Error en envio email: " . $e->getMessage();
                }
                Log::write("Envio email de factura", "Envio de email para factura [$factura->id_factura] con respuesta [$mensaje]");
            }
        }
        return $error;
    }
}
