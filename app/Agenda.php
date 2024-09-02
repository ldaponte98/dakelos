<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class Agenda extends Model
{
    protected $table      = 'agenda';

    protected $fillable = ['title','star', 'end', 'observaciones'];

    public function tercero()
    {
        return $this->belongsTo(Tercero::class, 'id_tercero');
    }

    public function profesional()
    {
        return $this->belongsTo(Tercero::class, 'id_profesional');
    }

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }

    public function enviar_email()
    {
        $agenda = $this;
        Agenda::ejecutar_envio_email($agenda);
    }

    public static function ejecutar_envio_email($agenda, $subtitulo = null)
    {
        $mensaje = "";
        $error   = true;
        $tercero = Tercero::find($agenda->id_tercero);
        $licencia = Licencia::find($tercero->id_licencia);
        $urlImagen = config('global.url_base')."/imagenes/licencia/";

        $subject = "Recordatorio de cita " . $licencia->nombe;
        $for     = $tercero->email;
        if($for != null && $for != "" && Agenda::is_valid_email($for)){
            $data_email = array(
                'tercero'     => $tercero,
                'title'    => $agenda->title,
                'subtitulo' => $subtitulo,
                'imagen_licencia' => $urlImagen.$licencia->imagen,
                'profesional' => $agenda->id_profesional,
                'start'      => $agenda->start,
                'licencia' =>  $licencia
            );
            if ($for) {
                try {
                    Mail::send('email.agenda', $data_email, function ($msj) use ($subject, $for, $licencia) {
                        $msj->from(config('global.email_app'), $licencia->nombre);
                        $msj->subject($subject);
                        $msj->to($for);
                    });
                    $error   = false;
                    $mensaje = "OK";
                } catch (Exception $e) {
                    $mensaje = "Error en envio email: " . $e->getMessage();
                }
                Log::write("Envio email de agenda", "Envio de email para agenda [$agenda->id] con respuesta [$mensaje]");
            }
        }
        return $error;
    }

    public static function is_valid_email($str)
    {
        return (false !== strpos($str, "@") && false !== strpos($str, "."));
    }
}
