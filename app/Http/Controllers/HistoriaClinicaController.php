<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tercero;
use App\HistoriaClinica;

class HistoriaClinicaController extends Controller
{
    public function mostrar(Request $request){

        return view('clinica/historiaClinica/administrar');
    }

    public function crear(){
 
        return view('clinica/historiaClinica/crear');
    }


}
