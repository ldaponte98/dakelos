<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class HistoriaClinica extends Model
{
    protected $table      = 'historia_clinica';


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
        $mensaje = "";
        $error   = true;
        $historia_clinica = $this;
        $licencia = Licencia::find(session('id_licencia'));
        $tercero = Tercero::find($historia_clinica->id_tercero);

        $subject = "Historia clinica". ' ' . $tercero->nombres . ' ' . $tercero->apellidos . ' - ' . $licencia->nombre;
        $for     = $tercero->email;
        if($for != null && $for != "" && $this->is_valid_email($for)){
            $data_email = array(
                'historia_clinica'  => $historia_clinica,
            );
            if ($for) {
                try {
                    Mail::send('email.historia_clinica', $data_email, function ($msj) use ($subject, $for) {
                        $msj->from(config('global.email_app'), session('nombre_licencia'));
                        $msj->subject($subject);
                        $msj->to($for);
                    });
                    $error   = false;
                    $mensaje = "OK";
                } catch (Exception $e) {
                    $mensaje = "Error en envio email: " . $e->getMessage();
                }
                Log::write("Envio email de historia clinica", "Envio de email para historia clinica [$historia_clinica->id] con respuesta [$mensaje]");
            }
        }
        return $error;
    }

    public function is_valid_email($str)
    {
        return (false !== strpos($str, "@") && false !== strpos($str, "."));
    }

}
