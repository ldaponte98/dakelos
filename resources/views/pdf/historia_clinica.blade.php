<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia clinica {{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .logo { 
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px; /* Ajusta el tamaño del logo */
        }

        h1,
        h2,
        h3 {
            color: #2c3e50;
            text-align: center;
        }

        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
            margin-top: 20px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 6px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .description {
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        .firma {
            margin-top: 6rem;
        }

    </style>
</head>

<body>
    <div class="container">

        {{-- <img class="logo" src="{{ $historia_clinica->licencia->get_imagen() }}"></td> --}}

        <h1>Historia Clínica</h1>
        <h2>{{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</h2>
        <small>{{$historia_clinica->created_at}}</small><br>
        <small>N° Historia Clínica: {{$historia_clinica->id}}</small>

        <h3 class="section-title">Datos personales</h3>
        <table>
            <tr>
                <th>Identificación:</th>
                <td>{{$historia_clinica->tercero->identificacion}}</td>
            </tr>
            <tr>
                <th>Sexo:</th>
                <td>{{$tipo_sexo->nombre}}</td>
            </tr>
            <tr>
                <th>Fecha Nacimiento:</th>
                <td>{{$historia_clinica->tercero->fecha_nacimiento}}</td>
            </tr>
            <tr>
                <th>Edad:</th>
                <td>{{$historia_clinica->tercero->get_edad()}} Años</td>
            </tr>
            <tr>
                <th>Dirección:</th>
                <td>{{$historia_clinica->tercero->direccion}}</td>
            </tr>
        </table>

        <h3 class="section-title">Descripción</h3>
        <p class="description">{{$historia_clinica->motivo}}
            <br><br>
            @if($historia_clinica->peso)
            {{$historia_clinica->peso}} Kg -
            @endif
            @if($historia_clinica->tension)
            {{$historia_clinica->tension}} mmHg-
            @endif
        </p>

        <h3 class="section-title">Indicaciones Médicas</h3>
        <p class="description">{{$historia_clinica->plan}}</p>
        <hr>

        <div class="firma">
            <p>Médico: {{$historia_clinica->profesional->nombres}}</p>
        </div>
    </div>
</body>

</html>

