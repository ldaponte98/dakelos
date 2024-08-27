<!DOCTYPE html>
<html>

<head>
    <style>
        /* Estilos CSS aquí */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            color: #6c757d;
            padding: 10px;
            text-align: center;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Recordatorio de Cita</h2>
        </div>
        <div class="content">
            <!-- Contenido del recordatorio aquí -->
            <p>Estimado/a {{ $tercero->nombres}} {{ $tercero->apellidos}},</p>
            <p>Este es un recordatorio de su cita programada con nosotros:</p>
            <ul>
                <li><strong>Fecha y hora:</strong> {{ $start }}</li>
                <li><strong>Lugar:</strong> {{ $licencia->direccion }}</li>
                <li><strong>Cuidad:</strong> {{ $licencia->ciudad }}</li>
            </ul>
            <p>Por favor, confirme su asistencia o comuníquese con nosotros si necesita reprogramar la cita.</p>
            <p>Gracias,<br>Equipo de {{ $licencia->nombre }}</p>
        </div>
        <div class="footer">
            <p>Este es un mensaje automático. Por favor, no responda a este correo electrónico.</p>
        </div>
    </div>
</body>
</html>
