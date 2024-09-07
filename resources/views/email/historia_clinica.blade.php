<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<style type="text/css">
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .container {
        font-family: Arial, sans-serif;
        color: #333;
        max-width: 600px;
        margin: auto;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }

    .info {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-top: 10px;
    }

</style>

<body> 
    @php
        $btn_descargar = true;
    @endphp

    <div class="container">
        <h1>Envío de Historia Clínica</h1>

        <p>Estimado/a <strong>{{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</strong>,</p>
        <p>Esperamos que se encuentre bien.</p>
        <p>Le informamos que su historia clínica está disponible para su descarga. A continuación, encontrará algunos de sus datos básicos:</p>

        <div class="info">
            <p><strong>Nombre Completo:</strong> {{$historia_clinica->tercero->nombres}} {{$historia_clinica->tercero->apellidos}}</p>
            <p><strong>Número de Identificación:</strong> {{$historia_clinica->tercero->identificacion}} </p>
            <p><strong>Fecha de la Consulta:</strong> {{$historia_clinica->created_at}} </p>
        </div>

        <p>Para descargar su historia clínica completa, por favor haga clic en el siguiente botón:</p>

        @if (isset($btn_descargar))
            <center>
                <a href="{{ route('clinica/historiaClinica/imprimir_historia', $historia_clinica->id) }}"
                    style="text-decoration: none;
                    padding-top: 10px !important;
                    padding-bottom:  10px !important;
                    padding-left:  70px !important;
                    padding-right:  70px !important;
                    font-weight: 600 !important;
                    font-size: 20px !important;
                    color: {{ $historia_clinica->licencia->color_letras }} !important;
                    background-color: {{ $historia_clinica->licencia->color_botones }} !important;
                    border-radius: 6px !important;
                    border: 2px solid {{ $historia_clinica->licencia->color_botones }} !important;
                    cursor: pointer !important;
                    ">Descargar
                </a>
            </center>
        @endif

        <p>Si tiene alguna duda o requiere asistencia, no dude en contactarnos.</p>

        <p>Atentamente,</p>
        <p><strong>{{$historia_clinica->licencia->nombre}} </strong><br>
            {{$historia_clinica->licencia->telefonos}}<br>
            {{$historia_clinica->licencia->email}}</p>
    </div>

</body>
</html>
