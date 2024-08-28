<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table      = 'historia_clinica';


    public function tercero()
    {
        return $this->belongsTo(Tercero::class, 'id_tercero');
    }
}
