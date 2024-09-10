<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaConfiguracionRecordatorio extends Model
{
    protected $table      = 'agenda_configuracion_recordatorio';
    protected $primaryKey = 'id';

    protected $fillable = [
        'unidad_tiempo',
        'tiempo',
        'estado',
    ];

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }
}
