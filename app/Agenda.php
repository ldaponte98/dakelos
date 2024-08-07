<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table      = 'agenda';

    protected $fillable = ['star', 'end', 'observaciones'];

    public function tercero()
    {
        return $this->belongsTo(Tercero::class, 'id_tercero');
    }
}
