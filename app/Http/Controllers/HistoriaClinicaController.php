<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tercero;
use App\Agenda;
use App\Dominio;
use App\HistoriaClinica;

class HistoriaClinicaController extends Controller
{
    public function crear(Request $request, $id)
    {
       

        $post = $request->all();
        $envio_correo = isset($post['envio_correo']);
        $imprimir_historia = isset($post['imprimir_historia']);
        DB::beginTransaction();
        $agenda = Agenda::find($id);
        if($agenda->atendida == 1){
            echo 'Esta agenda ya ha sido atendida'; die;
        }
        $tipo_sexo = Dominio::all()->where('id_dominio', $agenda->tercero->id_dominio_sexo)->first();

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
                $historiaClinica->tension                       =  $post->tension;
                $historiaClinica->peso                          =  $post->peso;
                $historiaClinica->plan                          =  $post->plan;
                $historiaClinica->id_licencia                   =  session('id_licencia');
                
                if($historiaClinica->save()){
                    $agenda->atendida = 1;
                    $agenda->save();
                    DB::commit();
                    if($envio_correo){$historiaClinica->enviar_email();}
                    return redirect()->route('clinica/calendario/atender')->with('status', 'Se creo la historia clinica correctamente');
                }else{
                    DB::rollBack();
                    throw new Exception("Ocurrio un error interno al crear la historia clinica, comuniquese con el administrador del sistema");
                    $errors = $historiaClinica->errors;
                }
                
            } catch (Exception $e) {
                $errores[] = "Ocurrio el siguiente error: " . $e->getMessage();
            }
        }
        return view('clinica.historiaClinica.crear', compact('agenda','historia_anterior', 'tipo_sexo'));
    }

    public function imprimir_historia($id_historia)
    {
        $historia_clinica = HistoriaClinica::find($id_historia);
        $tipo_sexo = Dominio::all()->where('id_dominio', $historia_clinica->tercero->id_dominio_sexo)->first();

        $pdf = \PDF::loadView('pdf.historia_clinica', compact(['historia_clinica','tipo_sexo']));
        return $pdf->stream("Historia clinica " . $historia_clinica->id . '.pdf');
    }
}
