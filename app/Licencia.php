<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    protected $table      = 'licencia';
    protected $primaryKey = 'id_licencia';

    protected $fillable = [
        'id_licencia',
        'nombre',
        'descripcion',
        'imagen',
        'imagen_small',
    ];

    public function get_imagen()
    {
        if ($this->imagen != null and $this->imagen != '') {
            return asset('imagenes/licencia/' . $this->imagen);
        } else {
            return asset('plantilla/images/app/zorax.png');
        }
    }

    public function get_imagen_email()
    {
        if ($this->imagen_url != null and $this->imagen_url != '') {
            return $this->imagen_url;
        }
        if ($this->imagen != null and $this->imagen != '') {
            return asset('imagenes/licencia/' . $this->imagen);
        }
        return "";
    }

    public function get_imagen_small()
    {
        if ($this->imagen_small != null and $this->imagen_small != '') {
            return asset('imagenes/licencia/' . $this->imagen_small);
        } else {
            return asset('plantilla/images/app/zorax_small.png');
        }
    }

    public function get_imagen_public()
    {
        if ($this->imagen != null and $this->imagen != '') {
            return public_path() . '/imagenes/licencia/' . $this->imagen;
        } else {
            return null;
        }
    }
}
