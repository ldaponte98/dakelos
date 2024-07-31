<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function administrar()
    {
        return view('citas.calendario.administrar');
    }
}
