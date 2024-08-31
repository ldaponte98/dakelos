<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tercero;
use App\Agenda;
use App\HistoriaClinica;

class HistoriaClinicaController extends Controller
{
    public function crear(Request $request, $id)
    {
        $post = $request->all();
        DB::beginTransaction();
        $agenda = Agenda::find($id);
        $historia_anterior = HistoriaClinica::where('id_tercero', $agenda->id_tercero)->where('estado', 1)->orderBy('id', 'DESC')->limit(1)->first();
        $errores = [];
        if($post){
            try {
                $post = (object) $post;
                $historiaClinica = new HistoriaClinica;
                $historiaClinica->id_profesional                =  session('id_tercero_usuario');
                $historiaClinica->id_tercero                    =  $agenda->id_tercero;
                $historiaClinica->antecedente_familiar          =  $post->antecedente['familiar'];
                $historiaClinica->antecedente_personal          =  $post->antecedente['personal'];
                $historiaClinica->antecedente_gineco_obstetrico =  $post->antecedente['gineco-obstetrico'];
                $historiaClinica->antecedente_cirugia           =  $post->antecedente['cirugia'];
                $historiaClinica->antecedente_medicamentos      =  $post->antecedente['medicamentos'];
                $historiaClinica->antecedente_alergias          =  $post->antecedente['alergias'];
                $historiaClinica->motivo                        =  $post->motivo;
                $historiaClinica->plan                          =  $post->plan;
                
                if($historiaClinica->save()){
                    DB::commit();
                    return redirect()->route('clinica/calendario/atender')->with('status', 'Se creo la historia clinica correctamente');
                }else{
                    DB::rollBack();
                    throw new Exception("Ocurrio un error interno al crear la historia clinica, comuniquese con el administrador del sistema");
                    $errors = $historiaClinica->errors;
                }
                if($post->motivo=='') throw new Exception("El paciente debe terner un motivo de consulta");
            } catch (Exception $e) {
                $errores[] = "Ocurrio el siguiente error: " . $e->getMessage();
            }
        }
        return view('clinica.historiaClinica.crear', compact('agenda','historia_anterior'));
    }


}
