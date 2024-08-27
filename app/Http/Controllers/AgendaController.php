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

    public function agendar(Request $request)
    {
        $post = $request->all();
        if($post){
            //se le suman 10 min a la fecha fin 
            $nuevaFechaEnd = Carbon::parse($post['end'])->addMinute(10)->format('Y-m-d H:i');
            $validar_tercero= Tercero::where('identificacion', $post['tercero']['identificacion'])->first();

            if($validar_tercero){
                $agenda = new Agenda();
                $agenda->id_profesional          =        $post['modal-profesional'];
                $agenda->id_tercero              =        $validar_tercero->id_tercero;
                $agenda->title                   =        $post['title'];
                $agenda->start                   =        date('Y-m-d H:i', strtotime($post['start']));
                $agenda->end                     =        $nuevaFechaEnd;
                $agenda->observaciones           =        $post['observaciones'];
                $agenda->id_usuario_creacion     =        session('id_usuario');
                $agenda->enviar_email();
                $agenda->save();
                return redirect()->route('citas/calendario/agendar');
            }else{
                $agenda = new Agenda();
                $tercero = new Tercero();
                $tercero->fill($post['tercero']);
                $tercero->id_dominio_tipo_tercero           =  3;
                $tercero->id_dominio_tipo_identificacion    =  $post['tercero']['id_dominio_tipo_identificacion'];
                $tercero->id_licencia = session('id_licencia');
                $tercero->save();

                if($tercero){
                    $agenda->id_profesional          =        $post['modal-profesional'];
                    $agenda->id_tercero              =        $tercero->id_tercero;
                    $agenda->title                   =        $post['title'];
                    $agenda->start                   =        date('Y-m-d H:i', strtotime($post['start']));
                    $agenda->end                     =        $nuevaFechaEnd;
                    $agenda->observaciones           =        $post['observaciones'];
                    $agenda->save();
                    return redirect()->route('citas/calendario/agendar');
                }
            }
        }

        return view('citas.calendario.agendar');
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
