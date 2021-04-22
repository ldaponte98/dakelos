<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\FacturaDetalle;
use App\FormaPago;

class ReporteController extends Controller
{
    public function facturas(Request $request)
    {
    	$post = $request->all();
    	$fecha_desde = date('Y-m-d')." 00:00";
    	$fecha_hasta = date('Y-m-d')." 23:59";

    	$fechas = "";
    	if($post){

    		$post = (object) $post;
    		$fechas = $post->fechas;
    		if($fechas != ""){
	            $fecha_desde = date('Y-m-d H:i', strtotime(explode('-', $post->fechas)[0]));
	            $fecha_hasta = date('Y-m-d H:i', strtotime(explode('-', $post->fechas)[1]));
    		}
    	}
    	$facturas = Factura::all()->where('id_licencia', session('id_licencia'));
    	if($fechas != ""){
    		$facturas = Factura::all()
    					->where('id_licencia', session('id_licencia'))
    					->whereBetween('fecha', [$fecha_desde, $fecha_hasta]);
    	}
    	$total_ventas = Factura::all()
    								->where('id_licencia', session('id_licencia'))
    								->where('id_dominio_tipo_factura',16)
    								->sum('valor');
    	$total_ventas_fecha = Factura::all()
    								->where('id_licencia', session('id_licencia'))
    								->where('id_dominio_tipo_factura',16)
    								->whereBetween('fecha', [$fecha_desde, $fecha_hasta])
    								->sum('valor');
    	$total_facturas_ventas = count(Factura::all()
    								->where('id_licencia', session('id_licencia'))
    								->where('id_dominio_tipo_factura',16));
    	$total_cotizaciones = count(Factura::all()
    								->where('id_licencia', session('id_licencia'))
    								->where('id_dominio_tipo_factura',17));
    	return view('reportes.facturas', compact([
    		'facturas',
    		'total_ventas',
    		'total_ventas_fecha',
    		'total_facturas_ventas',
    		'total_cotizaciones',
    		'fechas'
    	]));
    }
}
