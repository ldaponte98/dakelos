<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\Tercero;
use App\Dominio;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function mostrar($id)
    {
        $agendas = Agenda::where('id_profesional', $id)
        ->where('estado', 'ACTIVO')
        ->where('id_licencia', session('id_licencia'))
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
        ->where('id_licencia', session('id_licencia'))
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
        $profesionales = Tercero::all()->where('id_dominio_tipo_tercero', Dominio::get('Especialista'))->where('id_licencia', session('id_licencia'));
        $motivo_consulta = MotivoConsultaLicencia::all()->where('id_licencia', session('id_licencia'));
        $tipos_sexo = Dominio::all()->where('id_padre', Dominio::get('Tipos de sexo'));
        $tipos_identificacion = Dominio::all()->where('id_padre', Dominio::get('Tipos de identificacion'));

        $post = $request->all();
        $errores = [];
        $msgExitoso = null;
        $id_profesional_default = null;
        if($post != null){
            try {
                $post = (object) $post;
                $id_profesional_default = $post->id_profesional;
                if(isset($post->id_cita) && $post->id_cita != null && !in_array("all", $post->days)){
                    throw new Exception("Ocurrio un error, para editar la cita debe establecer la opcion Todos los dias");
                }
                $dateStart = date('Y-m-d', strtotime($post->start));
                $dateEnd = date('Y-m-d', strtotime($post->end));
                $validDates = false;
                $paciente= Tercero::where('identificacion', $post->tercero['identificacion'])->first();
                if($paciente == null){
                    $paciente = new Tercero();
                    $paciente->fill($post->tercero);
                    $paciente->id_dominio_tipo_tercero           =  Dominio::get('Cliente');
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
                        if(isset($post->id_cita) && $post->id_cita != null){
                            $agenda = Agenda::find($post->id_cita);
                        }
                        $agenda->id_profesional          = $post->id_profesional;
                        $agenda->id_licencia             = session('id_licencia');
                        $agenda->id_tercero              = $paciente->id_tercero;
                        $agenda->title                   = $paciente->nombres .' '. $paciente->apellidos .'-'. $post->title;
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
                return redirect()->route('clinica/calendario/agendar')->with('status', 'Se agendo al paciente correctamente');
            } catch (Exception $e) {    
                $errores[] = "Ocurrio el siguiente error: " . $e->getMessage();
            }
        }
        return view('clinica.calendario.agendar', 
            compact(['id_profesional_default', 'profesionales', 'motivo_consulta','tipos_sexo', 'tipos_identificacion'])
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
