<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia clinica {{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</title>   
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #000000;
        }

        .nota-medica {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-left {
            text-align: left;
        }

        .header-left .logo {
            max-width: 100px;
        }

        .header-right {
            text-align: right;
        }

        .header-right h3, .header-right h4 {
            margin: 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td, .info-table th {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .info-table th {
            background-color: #f0f0f0;
        }

        .fondo{
            background-color: #BFBFBF;"
        }

        strong {
            font-weight: bold;
        }

        p {
            margin: 5px 0;
        }
        .firma{
            margin-top: 6rem;
        }
    </style>
</head>

<body>
    <div class="nota-medica">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <img height="90" width="90" src="{{ $historia_clinica->licencia->get_imagen() }}"></td>
                </td>
                <td class="header-right">
                    <h3>HISTORIA CLINICA</h3>
                    <p>Fecha de Registro: <strong>{{$historia_clinica->created_at}}</strong></p>
                </td>
            </tr>
        </table>

        <!-- Datos Personales -->
        <table class="info-table">
            <tr>
                <td colspan="6" class="fondo"><strong>Datos personales:</strong></td>
            </tr>
            <tr>
                <td><strong>N° Historia Clínica:</strong></td>
                <td colspan="5">{{$historia_clinica->id}}</td> 
            </tr>

            <tr>
                <td><strong>Identificación:</strong></td>
                <td colspan="3">{{$historia_clinica->tercero->identificacion}}</td>
                <td><strong>Sexo:</strong></td>
                <td>{{$tipo_sexo->nombre}}</td>
            </tr>
            <tr>
                <td><strong>Nombre Paciente:</strong></td>
                <td colspan="5">{{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</td>
            </tr>
            <tr>
                <td><strong>Fecha Nacimiento:</strong></td>
                <td>{{$historia_clinica->tercero->fecha_nacimiento}}</td>
                <td><strong>Edad:</strong></td>
                <td colspan="3">{{$historia_clinica->tercero->get_edad()}} Años</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td colspan="5">{{$historia_clinica->tercero->direccion}}</td>
            </tr>
        </table>

        <!-- Descripción -->
        <table class="info-table">
            <tr>
                <td colspan="6" class="fondo"><strong>Descripción:</strong></td>
            </tr>
            <tr>
                <td colspan="6">{{$historia_clinica->motivo}}
                <br><br><br>
                {{$historia_clinica->peso}} Kg -
                {{$historia_clinica->tension}} mmHg
                </td>
            </tr>
        </table>

        <!-- Indicaciones Médicas -->
        <table class="info-table">
            <tr>
                <td colspan="6" class="fondo"><strong>Indicaciones Medicas:</strong></td>
            </tr>
            <tr>
                <td colspan="6">{{$historia_clinica->plan}}
                </td>
            </tr>
        </table>


        <!-- Footer -->
        <table class="firma">
            <tr>
                <td colspan="4">
                    <strong>Medico: </strong>{{$historia_clinica->profesional->nombres}}
                    <br>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
