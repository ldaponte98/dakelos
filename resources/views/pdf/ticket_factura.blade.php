<!DOCTYPE html>
<html>
<head>
	<title>Factura #{{ $factura->numero }}</title>
	<style>
		*{
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			margin: 7px;
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
				<th style="text-align: left; width: 50%;">Descripcion</th>
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
					<td>{{ ucfirst(strtolower($item->nombre_producto)) }}</td>
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
	<label><b>Observaciones:</b>{{ $factura->observaciones != "" ? $factura->observaciones : "Ninguna" }}</label><br>
	<br>
	<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		<tr>
			<td style="text-align: right; width: 80%"><b>Subtotal:</b></td>
			<td style="text-align: right;">${{ number_format($subtotal, 0, '.', '.') }}</td>
		</tr>
		<tr>
			<td style="text-align: right;"><b>Servicio Vol:</b></td>
			<td style="text-align: right;">${{ number_format($factura->servicio_voluntario, 0, '.', '.') }}</td>
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
		<tr>
			<td style="text-align: right;"><b>Total:</b></td>
			<td style="text-align: right; font-weight: bold;">${{ number_format($factura->valor, 0, '.', '.') }}</td>
		</tr>
	</table>
</body>
</html>