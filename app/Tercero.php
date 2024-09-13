<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime;
class Tercero extends Model
{
    protected $table = 'tercero';
    protected $primaryKey = 'id_tercero';

    protected $fillable = [
     	'id_tercero',
     	'nombres',
     	'apellidos',
     	'identificacion',
     	'email',
     	'telefono',
     	'direccion',
        'id_dominio_sexo',
        'fecha_nacimiento',
        'imagen',
        'imagen_firma',
        'id_dominio_tipo_tercero',
        'id_dominio_tipo_identificacion',
        'estado',
     	'id_licencia'
    ];

    public function nombre_completo()
    {
    	return $this->nombres." ".$this->apellidos;
    }

    public function tipo()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_tipo_tercero');
    }

    public function tipo_identificacion()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_tipo_identificacion');
    }
    public function sexo()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_sexo');
    }

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'id_tercero');
    }

    public function historia()
    {
        return $this->hasMany(HistoriaClinica::class, 'id_tercero');
    }

    public function get_estado()
    {
        switch ($this->estado) {
            case 1:
                return "Activo";

            case 0:
                return "Inactivo";
            
            default:
                return "Indefinido";
                break;
        }
    }

    public function get_imagen()
    {
    	if($this->imagen != null and $this->imagen != ''){
    		return asset('imagenes/tercero/'.$this->imagen);
    	}else{
    		return asset('plantilla/images/app/sinimagen.jpg');
    	}
    }

    public function get_imagen_firma()
    {
    	if($this->imagen_firma != null and $this->imagen_firma != ''){
    		return asset('imagenes/tercero/'.$this->imagen_firma);
    	}else{
    		return asset('imagenes/licencia/'.$this->imagen);
    	}
    }

    public function get_edad()
    {
        $cumpleanos = new DateTime($this->fecha_nacimiento);
        $hoy = new DateTime();
        $annos = $hoy->diff($cumpleanos);
        return $annos->y;
    }

    public function get_total_compras()
    {
        $facturas = Factura::all()
                             ->where('id_dominio_tipo_factura', 16)
                             ->where('id_tercero', $this->id_tercero)
                             ->where('id_licencia', session('id_licencia'));
        $total = 0;
        foreach ($facturas as $factura) {
           $total += $factura->valor;
        }
        return $total;
    }

    public function get_total_deuda()
    {
        $facturas = Factura::all()
                             ->where('estado', 1)
                             ->where('id_dominio_tipo_factura', Dominio::get("Factura a credito (Saldo pendiente)"))
                             ->where('id_tercero', $this->id_tercero)
                             ->where('valor', '>' , 0)
                             ->where('id_licencia', session('id_licencia'));
        $total = 0;
        foreach ($facturas as $factura) {
           $total += $factura->valor;
        }
        return $total;
    }

    public function get_total_ahorro()
    {
        $facturas = Factura::all()
                             ->where('estado', 1)
                             ->where('id_dominio_tipo_factura', Dominio::get("Recibo de caja"))
                             ->where('id_tercero', $this->id_tercero)
                             ->where('valor', '>' , 0)
                             ->where('id_licencia', session('id_licencia'));
        $total = 0;
        foreach ($facturas as $factura) {
           $total += $factura->valor;
        }
        return $total;
    }

    public function get_total_se_le_debe()
    {
        $facturas = Factura::all()
                             ->where('estado', 1)
                             ->where('id_dominio_tipo_factura', Dominio::get("Comprobante de egreso"))
                             ->where('id_tercero', $this->id_tercero)
                             ->where('valor', '>' , 0)
                             ->where('id_factura_cruce', null)
                             ->where('credito_comprobante_egreso', 1)
                             ->where('id_licencia', session('id_licencia'));
        $total = 0;
        foreach ($facturas as $factura) {
           $total += $factura->valor;
        }
        return $total;
    }

    public function get_total_productos_adquiridos()
    {
        $sql = "SELECT DISTINCT(descripcion_producto)
                        FROM factura_detalle fd 
                        LEFT JOIN factura f USING(id_factura) 
                        WHERE f.id_licencia = ".session('id_licencia')." 
                        and f.id_tercero = ".$this->id_tercero;
        $response = DB::select($sql);
        return count($response);
    }


}
