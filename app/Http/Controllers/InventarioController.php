<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function administrar(Request $request)
    {
        $post        = (object) $request->all();
        $inventarios = DB::table('inventario')->where('id_licencia', session('id_licencia'))->paginate(10);
        return view('inventario.movimientos', compact('inventarios'));
    }

}
