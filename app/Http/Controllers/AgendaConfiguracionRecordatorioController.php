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
        $this->current_date = date('Y-m-d H:i');
        $this->log("Ejecutando job para recordatorio de citas agendas...");
        $licencias = Licencia::where('estado', 1)->get();
        $this->log("Ejecutando job para " . count($licencias) . " licencias activas");
        foreach ($licencias as $licencia) {
            $this->log("----------------------------- INICIO [". $licencia->nombre . " (".$licencia->id_licencia.")" ."] -----------------------------");
            $recordatorios = AgendaConfiguracionRecordatorio::where('id_licencia', $licencia->id_licencia)
                                ->where('estado', 1)
                                ->get();
            $this->log("Aplicando " . count($recordatorios) . " recordatorios activos configurados. <br>");
            foreach ($recordatorios as $recordatorio) {
                $this->generar_recordatorio($recordatorio);
            }
            $this->log("------------------------------ FIN [". $licencia->nombre . " (".$licencia->id_licencia.")" ."] -------------------------------");
        }
    }

    public function generar_recordatorio($recordatorio)
    {
        $this->log("----------------------------- INICIO RECORDATORIO ". $recordatorio->tiempo . " ".$recordatorio->unidad_tiempo. "-----------------------------");
        $agendas_recordar = $this->buscar_agendas_por_recordatorio($recordatorio);
        $this->log("Recordando a " . count($agendas_recordar) . " citas para esta config de recordatorio");
        foreach ($agendas_recordar as $agenda) {
            $subtitulo = $this->generar_subtitulo_mensaje($recordatorio);
            Agenda::ejecutar_envio_email($agenda, $subtitulo);
            $this->log("Enviado recordatorio a agenda #" . $agenda->id . " [".$agenda->email. "]");
        }
        $this->log("----------------------------- FIN RECORDATORIO ". $recordatorio->tiempo . " ".$recordatorio->unidad_tiempo. "-----------------------------<br><br>");
    }

    public function buscar_agendas_por_recordatorio($recordatorio)
    {
        $date = $this->current_date;
        $id_licencia = $recordatorio->id_licencia;
        $sql = "SELECT a.*, 
        p.email,
        TIMEDIFF(a.start, '$date:00') AS diferencia
        FROM agenda a 
        INNER JOIN tercero t ON t.id_tercero = a.id_profesional
        INNER JOIN tercero p ON p.id_tercero = a.id_tercero
        WHERE a.start > '$date:00'
        AND a.estado = 'ACTIVO'
        AND t.id_licencia = $id_licencia";
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
        $horas = explode(":", $agenda->diferencia)[0];
        $minutos = explode(":", $agenda->diferencia)[1];
        $dias = $horas / 24;
        if($recordatorio->unidad_tiempo == "DIA" && $dias == $recordatorio->tiempo){
            return true;
        }
        if($recordatorio->unidad_tiempo == "HORA" && $horas == $recordatorio->tiempo){
            return true;
        }
        return false;
    }

    public function generar_subtitulo_mensaje($recordatorio)
    {
        $mensajes = [
            "DIA" => "Tu cita empieza en " . $recordatorio->tiempo . " días",
            "HORA" => "Tu cita empieza en " . $recordatorio->tiempo . " horas"
        ];
        return $mensajes[$recordatorio->unidad_tiempo];
    }

    public function administrar()
    {
        $recordatorios = AgendaConfiguracionRecordatorio::where('id_licencia', session('id_licencia'))->get();
        return view('configuracion.agenda-recordatorio.administrar', compact(['recordatorios']));
    }

    public function guardar(Request $request, $id = null)
    {
        $post            = $request->all();
        $recordatorio    = new AgendaConfiguracionRecordatorio;
        $recordatorio->tiempo = 1;
        $recordatorio->estado = null;
        if ($id != null) {
            $recordatorio  = AgendaConfiguracionRecordatorio::find($id);
        }

        $unidades_tiempo = [
            (object) [ "id" => "DIA", "label" => "Día"],
            (object) [ "id" => "HORA", "label" => "Hora"]
        ];
        $errors   = [];
        if ($post) {
            $post = (object) $post;
            $recordatorio->fill($request->except(['_token']));
            $existe = AgendaConfiguracionRecordatorio::where('id_licencia', session('id_licencia'))
                ->where('unidad_tiempo', $post->unidad_tiempo)
                ->where('tiempo', $post->tiempo)
                ->first();
            $valid_edit = false;
            if($id != null && $existe != null){
                if($existe->id == $id) $valid_edit = true;
            }
            if ($existe == null || $valid_edit == true) {
                $recordatorio->id_licencia = session('id_licencia');
                $recordatorio->save();
                return redirect()->route('agenda-recordatorio/administrar');
            } else {
                $errors[] = "Ya existe un recordatorio registrado con el mismo tiempo y unidad de tiempo.";
            }
        }
        return view('configuracion.agenda-recordatorio.form', compact(['recordatorio', 'unidades_tiempo', 'errors']));
    }
}
