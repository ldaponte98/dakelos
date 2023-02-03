<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		*{
			font-family: Arial, Helvetica, sans-serif;
		}
		.fondo{
			background-color: #ffffff;
			text-align: center;
			padding-top: 20px;
			padding-bottom: 20px;
			width: 100% !important;
		}
		.fondo h1{
			color: #ffffff;
		}
	</style>
</head>
<body>
	<h1><b>Alerta inventario</b></h1>
	<p>El software <b>ARSI</b> informa que el material <b>{{ strtoupper($producto->nombre) }}</b>, superó los (<b>{{ $producto->cantidad_actual }}</b>) Kilogramos KG almacenados en bodega</p>
</body>
</html>