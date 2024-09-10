<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotivoConsultaLicencia extends Model
{
    protected $table      = 'motivo_consulta_licencia';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_dominio',
        'id_licencia'
    ];

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }

    public function dominio()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio');
    }

}
