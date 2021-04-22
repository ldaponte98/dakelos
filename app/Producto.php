<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
     	'id_producto',
     	'nombre',
     	'descripcion',
     	'id_categoria',
        'cantidad_minimo_alerta',
        'cantidad_actual',
        'contenido',
        'descontado',
        'precio_compra',
        'precio_venta',
        'iva',
        'imagen',
        'id_dominio_presentacion',
        'estado',
        'id_usuario_registra',
     	'id_licencia'
     ];

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }
    public function tipo()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_tipo_producto');
    }
    public function presentacion()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio_presentacion');
    }
    public function get_imagen()
     {
     	if($this->imagen != null and $this->imagen != ''){
    		return asset('imagenes/producto/'.$this->imagen);
    	}else{
    		return asset('plantilla/images/app/sinimagen.jpg');
    	}
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

}
