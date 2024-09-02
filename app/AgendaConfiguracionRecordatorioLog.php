<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaConfiguracionRecordatorioLog extends Model
{
    protected $table      = 'agenda_configuracion_recordatorio_log';
    protected $primaryKey = 'id';

    public function agendaConfiguracionRecordatorio()
    {
        return $this->belongsTo(AgendaConfiguracionRecordatorio::class, 'id_agenda_configuracion_recordatorio');
    }
}
