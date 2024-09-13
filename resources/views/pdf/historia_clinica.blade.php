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
            left: 20px;
            width: 100px; 
        }

        h1,
        h2,
        h3 {
            color: #2c3e50;
            text-align: center;
        }

        .fecha_registro {
            width: 100%;
           text-align: right;
        }

        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
            margin-top: 20px;
            border-radius: 5px;
        }

        .datos_personales {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .datos_personales th,
        .datos_personales td {
            padding: 6px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .antecedentes th,
        .antecedentes td {
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .antecedentes tbody tr th {
            width: 30%;
        }

        .description,
        .fecha_registro {
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        .firma {
            margin-top: 6rem;
        }

        .img_firma{
            width: 150px;
            height: 70px;
        }

    </style>
</head>

<body>
    <div class="container">

        <img class="logo" src="{{ $historia_clinica->licencia->get_imagen() }}">

        <h1>Historia Clínica</h1>
        <h2>{{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</h2>
        
        <div class="fecha_registro">
            <div>N° Historia Clínica: {{$historia_clinica->id}} </div>
            <div>Fecha registro: {{$historia_clinica->created_at}} </div>      
        </div>

        <h3 class="section-title">Datos personales</h3>
        <table class="datos_personales">
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
            {{$historia_clinica->peso}} Kg
            @endif
            @if($historia_clinica->tension)
            {{$historia_clinica->tension}} mmHg
            @endif
        </p>
        <hr>

        <h3>Antecedentes</h3>
        <table class="antecedentes">
            <tbody class="description">
                <tr>
                    <th><b>Familiares:</b></th>
                    <td>{{$historia_clinica->antecedente_familiar}}</td>
                </tr>
                <tr>
                    <th><b>Personales:</b></th>
                    <td>{{$historia_clinica->antecedente_personal}}</td>
                </tr>
                <tr>
                    <th><b>Gineco-obstétricos:</b></th>
                    <td>{{$historia_clinica->antecedente_gineco_obstetrico}}</td>
                </tr>
                <tr>
                    <th><b>Cirugía:</b></th>
                    <td>{{$historia_clinica->antecedente_cirugia}}</td>
                </tr>
                <tr>
                    <th><b>Recibe medicamentos:</b></th>
                    <td>{{$historia_clinica->antecedente_medicamentos}}</td>
                </tr>
                <tr>
                    <th><b>FUM Alergias:</b></th>
                    <td>{{$historia_clinica->antecedente_alergias}}</td>
                </tr>
        </tbody>
        </table>

        <h3 class="section-title">Indicaciones Médicas</h3>
        <p class="description">{{$historia_clinica->plan}}</p>
        <hr>

        <div class="firma">
        <img class="img_firma" src="{{ $historia_clinica->tercero->get_imagen_firma() }}" alt="Firma">
        <p>Médico: {{$historia_clinica->profesional->nombres}}</p>
        </div>
    </div>
</body>

</html>

