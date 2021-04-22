<!DOCTYPE html>
@php
	$factura = \App\Factura::find(61);
@endphp
<html>
<head>

	<title>{{ $factura->tipo->nombre }}
		</title>
	<style>
		.page-break {
		    page-break-after: always;
		}
		*{
			font-family: Arial, Helvetica, sans-serif;
		}	
	p{
		font-weight: bold;
		margin: 3px !important;
	}
	table{
		width: 100%;
	}

	.td_1{
		font-size: 14px;
		width: 1px;
		padding-top: 17px;
		margin-bottom: 0px;

	}
	.td_2{
		font-size: 14px;
		width: 1px;
		padding-top: 9px;
		margin-bottom: 0px;
	}
	.td_3{
		font-size: 14px;
		padding-top: 5px;
		width: 50%
	}
	.pegados_1{
		border-bottom: 0.5px solid #000000;
		margin-top: 8px;
		font-size: 14px;
		width: 100%;
		margin-left: 5px;
		margin-bottom: 0px;
		font-weight: bold;

	}
	.pegados_2{
		border-bottom: 0.5px solid #000000;
		margin-top: 5px;
		font-size: 12px;
		width: 100%;
		margin-left: 5px;
		margin-bottom: 0px;
		font-weight: bold;

	}
	.tabla_1 td{
		padding-left: 10px !important;
		padding-top: 3px !important;
		padding-bottom: 3px !important;
		font-size: 14px;
	}
	.tabla_1 th{
		padding-top: 5px !important;
		padding-bottom: 5px !important;
		font-size: 14px;
	}
	.tabla_4 td{
		padding-top: 3px !important;
		padding-bottom: 3px !important;
		font-size: 12px;
	}

	.tabla_2 td{
		padding-left: 10px !important;
		padding-top: 5px !important;
		padding-bottom: 5px !important;
		font-size: 10px;
	}

	.tabla_3 td{
		padding-top: 8px !important;
		padding-bottom: 8px !important;
		font-size: 10px;
	}

</style>

</head>
<body>

<!--aca comienza la info del registro-->



<br>

<table class="tabla_1" border="1" cellpadding="0" cellspacing="0">
	<tr>
		@if($factura->licencia->imagen != null and $factura->licencia->imagen != "")
			<td colspan="3" rowspan="4" style="width:30px;border-right: none; border-bottom: none; border-top: none;"><img  src="{{ $factura->licencia->get_imagen_email() }}"></td>
		@else
			<td colspan="3" rowspan="4" style="border-right: none; border-bottom: none; border-top: none;"><center><img   src="plantilla/images/app/sinimagen.jpg"></center></td>
		@endif
		<td colspan="5" style="border-left: none; border-bottom: none; font-size: 16px; border-top: none;"><center>{{ $factura->licencia->direccion }}</center></td>
		<td colspan="3" style="background-color: #BFBFBF; font-size:14px;"><center><b>{{ strtoupper($factura->tipo->nombre) }}</b></center></td>
	</tr>
	<tr>
		<td colspan="5" style="border-left: none; border-top: none; border-bottom: none; font-size: 16px;"><center>{{ $factura->licencia->ciudad }}</center></td>
		<td colspan="3"><center>{{ $factura->numero }}</center></td>
	</tr>
	<tr>
		<td colspan="5" style="border-left: none; border-top: none; border-bottom: none; font-size: 16px;"><center>{{ $factura->licencia->telefono }}</center></td>
		<td colspan="3" style="background-color: #BFBFBF;"><center><b>Fecha</b></center></td>
	</tr>
	<tr>
		<td colspan="5" style="border-left: none; border-top: none; border-bottom: none; font-size: 16px;"><center>NIT. {{ $factura->licencia->nit }}</center></td>
		<td><center>{{ date('d', strtotime($factura->fecha)) }}</center></td>
		<td><center>{{ date('m', strtotime($factura->fecha)) }}</center></td>
		<td><center>{{ date('Y', strtotime($factura->fecha)) }}</center></td>
	</tr>
	</table>
	<table class="tabla_1" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="10" style="border-top: none; background-color: #BFBFBF"><center><b>FACTURADO A:</b></center></td>
	</tr>
	<tr>
		<td colspan="10"><b>Cliente: </b>{{ $factura->tercero->nombre_completo() }}</td>
	</tr>
	<tr>
		<td colspan="5"><b>CC o Nit: </b>{{ $factura->tercero->identificacion }}</td>
		<td colspan="5"><b>Telefono: </b>{{ $factura->tercero->telefono }}</td>
	</tr>
	<tr>
		<td colspan="10"><b>Direccion: </b>{{ $factura->tercero->direccion }}</td>
	</tr>
	<tr>
		<td colspan="10" style="border-top: none;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="10" style="border-top: none; background-color: #BFBFBF"><center><b>PRODUCTOS</b></center></td>
	</tr>
	<tr>
		<td style="background-color: #BFBFBF"><center><b>ITEM</b></center></td>
		<td style="background-color: #BFBFBF" colspan="2"><center><b>DESCRIPCIÓN</b></center></td>
		<td style="background-color: #BFBFBF"><center><b>CANT</b></center></td>
		<td style="background-color: #BFBFBF" colspan="2"><center><b>Vr. UNIT</b></center></td>
		<td style="background-color: #BFBFBF"><center><b>IVA</b></center></td>
		<td style="background-color: #BFBFBF"><center><b>DESC</b></center></td>
		<td style="background-color: #BFBFBF" colspan="2"><center><b>Vr. TOTAL</b></center></td>
	</tr>
	@php $cont = 1; $total_iva = 0; $subtotal = 0;@endphp
	@foreach($factura->detalles as $detalle)
	@php
			$valor_producto = $detalle->precio_producto;
			$valor_iva = 0;

				if($detalle->iva_producto != null and $detalle->iva_producto != ""){
					$valor_iva = $valor_producto * ($detalle->iva_producto/100);
					$valor_producto = $detalle->precio_producto;
				}
			$total_iva += $valor_iva;
			$subtotal += $valor_producto - $detalle->descuento_producto;
	@endphp
	<tr>
		<td><center>{{ $cont }}</center></td>
		<td colspan="2">{{ $detalle->descripcion_producto }}</td>
		<td>1</td>
		<td colspan="2">${{ number_format($valor_producto, 0, '.','.') }}</td>
		<td>${{ number_format($valor_iva, 0, '.','.') }}</td>
		<td>${{ number_format($detalle->descuento_producto, 0, '.','.') }}</td>
		<td colspan="2">${{ number_format($valor_producto + $valor_iva - $detalle->descuento_producto, 0, '.','.') }}</td>
	</tr>
	@php $cont++; @endphp
	@endforeach
	<tr>
		<td colspan="7" style="border-bottom: none;"><center></center></td>
		<td colspan="3" style="background-color: #BFBFBF; "><b>SUBTOTAL: </b>${{ number_format($subtotal, 0, '.','.') }}</td>
	</tr>
	<tr>
		<td colspan="7" style="border-bottom: none; border-top: none; border-bottom: none; font-size:8px;"><center>Formulario dian 18762013422870 de 2019/03/12 habilitada del 00001 al 1000.<br>Esta factura se asimila en todos sus efectos legales a una letra de Cambio según art.774 del Código de Comercio.</center></td>
		<td colspan="3" style="border-bottom: none; background-color: #BFBFBF;"><b>IVA: </b>${{ number_format($total_iva, 0, '.','.') }}</td>
	</tr>
	<tr>
		<td colspan="7" style="border-bottom: none;  border-top: none;">&nbsp;</td>
		<td colspan="3" style="border-bottom: none; background-color: #BFBFBF;"><b>TOTAL: </b>${{ number_format($factura->valor, 0, '.','.') }}</td>
	</tr>
	<tr>		
	<td colspan="10"><b>Observaciones: </b><br>{{ $factura->observaciones}}</td>
	</tr>
	@if($factura->id_dominio_tipo_factura == 17)
	<tr>
		<td colspan="10">
			<center>
				<b>
					<i>Esta cotización es valida por los siguientes 30 dias calendario</i>
				</b>
			</center>
		</td>
	</tr>
	
	@endif
	
</table>

<br><br>
@if(isset($btn_descargar)) 
<center>
<a href="{{ route('factura/imprimir', $factura->id_factura) }}" style="text-decoration: none;
    padding-top: 10px !important;
    padding-bottom:  10px !important;
    padding-left:  70px !important;
    padding-right:  70px !important;
    font-weight: 600 !important;
    font-size: 20px !important;
    color: {{ $factura->licencia->color_letras }} !important;
    background-color: {{ $factura->licencia->color_botones }} !important;
    border-radius: 6px !important;
    border: 2px solid {{ $factura->licencia->color_botones }} !important;
    cursor: pointer !important;
    ">Descargar</a>
</center>
@endif
</body>

</html>
