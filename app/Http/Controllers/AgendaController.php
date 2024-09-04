<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\Tercero;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function mostrar($id)
    {
        $agendas = Agenda::where('id_profesional', $id)
        ->where('estado', 'ACTIVO')
        ->with('tercero')
        ->get();
        return response()->json([
            'error' => false,
            'message' => 'OK',
            'data' => $agendas
        ]);
    }

    public function agendaProfesional()
    {   
        $agendas = Agenda::where('id_profesional', session('id_tercero_usuario'))
        ->where('estado', 'ACTIVO')
        ->with('tercero')
        ->get();
        return response()->json([
            'error' => false,
            'message' => 'OK',
            'data' => $agendas
        ]);
    }

    public function atender()
    {
        
        return view('clinica.calendario.agendaProfesional');
    }

    public function agendar(Request $request)
    {
        $post = $request->all();
        $errores = [];
        $msgExitoso = null;
        $id_profesional_default = null;
        if($post != null){
            try {
                $post = (object) $post;
                $id_profesional_default = $post->id_profesional;
                $dateStart = date('Y-m-d', strtotime($post->start));
                $dateEnd = date('Y-m-d', strtotime($post->end));
                $validDates = false;
                $paciente= Tercero::where('identificacion', $post->tercero['identificacion'])->first();
                if($paciente == null){
                    $paciente = new Tercero();
                    $paciente->fill($post->tercero);
                    $paciente->id_dominio_tipo_tercero           =  3;
                    $paciente->id_dominio_tipo_identificacion    =  $post->tercero['id_dominio_tipo_identificacion'];
                    $paciente->id_licencia = session('id_licencia');
                    $paciente->save();
                }
                while ($dateStart <= $dateEnd) {
                    $dayWeek = $this->getDayWeek($dateStart);
                    if(in_array("all", $post->days) || in_array($dayWeek, $post->days)){
                        $validDates = true;
                        $timeStart = date('H:i', strtotime($post->start));
                        $timeEnd = date('H:i', strtotime($post->end));
                        $agenda = new Agenda();
                        $agenda->id_profesional          = $post->id_profesional;
                        $agenda->id_tercero              = $paciente->id_tercero;
                        $agenda->title                   = $post->title;
                        $agenda->start                   = $dateStart . " " . $timeStart.':00';
                        $agenda->end                     = $dateStart . " " . $timeEnd.':59';
                        $agenda->observaciones           = $post->observaciones;
                        $agenda->id_usuario_creacion     = session('id_usuario');
                        if(!$agenda->save()){
                            throw new Exception("Ocurrio un error interno al programar la cita, comuniquese con el administrador del sistema");
                        }
                        $agenda->enviar_email();
                    }
                    $dateStart = date('Y-m-d', strtotime($dateStart . " +1 days"));
                }
                if(!$validDates) throw new Exception("No se pudieron programar citas validas porque las fechas y dias de las citas no coincidieron en ningun escenario");
                return redirect()->route('clinica/calendario/agendar');
            } catch (Exception $e) {    
                $errores[] = "Ocurrio el siguiente error: " . $e->getMessage();
            }
        }
        return view('clinica.calendario.agendar', 
            compact(['id_profesional_default'])
        );
    }

    public function cancelar($id){
        $agenda = Agenda::find($id);
        $agenda->estado = 'CANCELADO';
        $agenda->id_usuario_cancelacion = session('id_usuario');
        $agenda->save();
        
        return response()->json([
            'error' => false,
           'message' => 'La cita se ha cancelado correctamente',
           'data' => $agenda
        ]);

    }
}
