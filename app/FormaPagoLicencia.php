<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class FormaPagoLicencia extends Model
{
    protected $table      = 'forma_pago_licencia';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_dominio',
        'id_licencia'
    ];

    public function licencia()
    {
        return $this->belongsTo(Licencia::class, 'id_licencia');
    }

    public function dominio()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio');
    }

    public static function getDominios($id_licencia, $excludes = []){
        $relations = FormaPagoLicencia::where('id_licencia', $id_licencia)->get();
        $result = [];
        foreach ($relations as $relation) {
            if(!FormaPagoLicencia::inArray($excludes, $relation->id_dominio)){
                $result[] = $relation->dominio;
            }
        }
        return $result;
    }

    public static function inArray($array, $value, $column_name = null){
        foreach ($array as $item) {
            if($column_name == null){
                if($item == $value){
                    return true;
                } 
            }else{
                if($item[$column_name] == $value) return true;
            }
        }
        return false;
    }
}
