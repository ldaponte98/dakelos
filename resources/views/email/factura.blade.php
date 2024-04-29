<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<style type="text/css">
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    .fondo {
        background-color: #ffffff;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        width: 100% !important;
    }

    .fondo h1 {
        color: #ffffff;
    }
</style>

<body>
    @php
        $btn_descargar = true;
    @endphp
    {{ view('pdf.factura', compact('factura', 'btn_descargar')) }}
</body>
</html>
