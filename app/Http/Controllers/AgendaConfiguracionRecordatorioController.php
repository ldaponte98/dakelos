<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\Tercero;
use App\Licencia;
use App\AgendaConfiguracionRecordatorio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AgendaConfiguracionRecordatorioController extends Controller
{
    private $current_date = null;

    public function log($message)
    {
        echo date('Y-m-d H:i:s') . " -> $message <br>";
    }

    public function job_recordatorios(){
        $this->current_date = date('Y-m-d H:m');
        $this->log("Ejecutando job para recordatorio de citas agendas...");
        $licencias = Licencia::where('estado', 1)->get();
        $this->log("Ejecutando job para " . count($licencias) . " activas");
        foreach ($licencias as $licencia) {
            $this->log("----------------------------- [". $licencia->nombre . " (".$licencia->id_licencia.")" ."] -----------------------------");
            $recordatorios = AgendaConfiguracionRecordatorio::where('id_licencia', $licencia->id_licencia)
                                ->where('estado', 1)
                                ->get();
            $this->log("Aplicando " . count($recordatorios) . " recordatorios activos configurados");
            foreach ($recordatorios as $recordatorio) {
                $this->generar_recordatorio($recordatorio);
            }
            $this->log("-----------------------------------------------------------------------------------------------------------------------");       
        }
    }

    public function generar_recordatorio($recordatorio)
    {
        $this->log("----------------------------- INICIO RECORDATORIO ". $recordatorio->tiempo . " ".$recordatorio->unidad_tiempo. "-----------------------------");
        $agendas_recordar = $this->buscar_agendas_por_recordatorio($recordatorio);
        $this->log("----------------------------- FIN RECORDATORIO ". $recordatorio->tiempo . " ".$recordatorio->unidad_tiempo. "-----------------------------");
    }

    public function buscar_agendas_por_recordatorio($recordatorio)
    {
        $date = $this->current_date;
        $sql = "SELECT a.*, 
        TIMEDIFF(a.start, '$date:00') AS diferencia
        FROM agenda a 
        INNER JOIN tercero t ON t.id_tercero = a.id_profesional
        WHERE a.start > '$date:00'
        AND a.estado = 'ACTIVO'
        AND t.id_licencia = 1";
        $agendas_validas = DB::select($sql);
        $agendas_recordar = [];
        foreach ($agendas_validas as $agenda) {
            if($this->agenda_valida_para_recordatorio($agenda, $recordatorio)){
                $agendas_recordar[] = $agenda;
            }
        }
        return $agendas_recordar;
    }

    public function agenda_valida_para_recordatorio($agenda, $recordatorio)
    {
        
    }

}
