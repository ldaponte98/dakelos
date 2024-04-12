<!DOCTYPE html>
<html>
<head>
	<title>Factura #{{ $factura->numero }}</title>
	<style>
		*{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			margin: 5px;
		}	
	</style>
</head>
<body>
	@if ($factura->licencia->get_imagen_public())
		<center>
			<img src="{{ $factura->licencia->get_imagen_public() }}" width="90" height="65">
		</center>
	@endif
	<center>
		<label ><b style="font-size: 14px;">{{ $factura->licencia->nombre }}</b></label><br>
		<label><b>Ciudad: </b>{{ $factura->licencia->ciudad }}</label><br>
		@if ($factura->licencia->nit)
			<label><b>Nit:</b>{{ $factura->licencia->nit }}</label><br>
		@endif
		@if ($factura->licencia->direccion)
			<label><b>Direccion:</b>{{ $factura->licencia->direccion }}</label><br>
		@endif
		@if ($factura->licencia->telefonos)
			<label><b>Telefonos:</b>{{ $factura->licencia->telefonos }}</label><br>
		@endif
		@if ($factura->licencia->email)
			<label><b>Email:</b>{{ $factura->licencia->email }}</label><br>
		@endif
	</center>
	<br><br>
	<label><b>Factura #{{ $factura->numero }}</b></label><br><br>
	<label><b>Informacion del cliente</b></label><br>
	<label><b>Nombre:</b>{{ $factura->tercero->nombre_completo() }}</label><br>
	<label><b>Identificación:</b>{{ $factura->tercero->identificacion != "000000000" ? $factura->tercero->identificacion : "No definida" }}</label><br>
	<label><b>Telefono:</b>{{ $factura->tercero->telefono ? $factura->tercero->telefono : "No definido" }}</label><br>

	@if ($factura->canal->id_dominio == App\Dominio::get('Mesa'))
		<label><b>Mesa:</b>{{ $factura->mesa->numero }}</label><br>
	@endif
	@if ($factura->canal->id_dominio == App\Dominio::get('Domicilio'))
		<label><b>Dirección:</b>{{ $factura->direccion != "" ? $factura->direccion : "No definida" }}</label><br>
	@endif
	<br>
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		<thead>
			<tr>
				<th style="text-align: left; width: 50%;">Producto</th>
				<th style="text-align: right;">Cant</th>
				<th style="text-align: right;">Total</th>
			</tr>
		</thead>
		<tbody>
			@php
				$subtotal = 0;
			@endphp
			@foreach ($factura->detalles as $item)
				<tr>
					<td>{{ ucfirst(strtolower(deleteTilds($item->nombre_producto))) }}</td>
					<td style="text-align: right;">{{ $item->cantidad }} {{ $item->presentacion_producto }}</td>
					<td style="text-align: right;">${{ number_format(($item->cantidad * $item->precio_producto), 0, '.', '.') }}</td>
				</tr>
				@php
					$subtotal += $item->cantidad * $item->precio_producto;
				@endphp
			@endforeach
		</tbody>
	</table>
	<br>
	<label><b>Descripcion:</b>{{ $factura->descripciones != "" ? $factura->descripciones : "Ninguna" }}</label><br>
	<br>
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		<tr>
			<td style="text-align: right; width: 80%"><b>Subtotal:</b></td>
			<td style="text-align: right;">${{ number_format($subtotal, 0, '.', '.') }}</td>
		</tr>
		
		@if ($factura->canal->id_dominio != App\Dominio::get('Mesa'))
		<tr>
			<td style="text-align: right;"><b>Domicilio:</b></td>
			<td style="text-align: right;">${{ number_format($factura->domicilio, 0, '.', '.') }}</td>
		</tr>
		@endif
		<tr>
			<td style="text-align: right;"><b>Descuento:</b></td>
			<td style="text-align: right;">${{ number_format($factura->descuento, 0, '.', '.') }}</td>
		</tr>
		@if ($factura->abono_inicial > 0)
			<tr>
				<td style="text-align: right;"><b>Abono inicial:</b></td>
				<td style="text-align: right;">${{ number_format($factura->abono_inicial, 0, '.', '.') }}</td>
			</tr>
		@endif
		<tr>
			<td style="text-align: right;"><b>Total:</b></td>
			<td style="text-align: right; font-weight: bold;">${{ number_format($factura->valor, 0, '.', '.') }}</td>
		</tr>		
	</table>
	<br>
	<center><label style="font-size: 4px;" class="mx-5">En cumplimiento de la<b style="font-size: 3px;">ley estatutaria 1581 del 2012,</b> de protección de datos, informamos que mediante el registro de sus datos en la presente factura, usted autoriza a<b style="font-size: 3px;">MAROLI JOYERÍA</b>para que éstos sean incorporados en sus bases de datos con la finalidad de generar facturas, cuentas de cobro y demás tipos de contratos que se den de forma contractual y prospección comercial. Así mismo, le informamos en la recolección, almacenamiento y uso de sus datos serán tratados conforme al ordenamiento legal vigente que rige la protección, de datos personales entregados de los titulares. Usted puede ejercitar los derechos a conocer, corregir, actualizar, suministrar y/o revocar la autorización dada, mediante escrito dirigido a<b style="font-size: 3px;">MAROLI JOYERÍA</b></label></center>

	<center><label><b style="font-size: 4px;">Todas nuestras joyas están elaboradas en oro 18 k por lo tanto se garantiza el material. No cubre danos originados por mal uso </b></labe>
	
		<br><br>
	@if ($factura->estado == 0)
		<center>
			<label ><b style="font-size: 32px; color: red;">Cancelada</b></label>
		</center>
	@endif
</body>
</html>

@php
	function deleteTilds($cadena)
    {
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹", "Ñ", "ñ");
        $permitidas    = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E", "Ñ", "N");
        $texto         = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }
@endphp