<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBListaCliente extends Model
{
    protected $table = 'WEB.LISTACLIENTE';
    public $timestamps=false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    public function scopeName($query,$name){

    	if(trim($name) != ''){
    		$query->where('NOM_EMPR', '=', $name);
    	}

    }

    public function scopeTipodocumento($query,$tipo){

    	if(trim($tipo) != ''){
    		$query->where('COD_TIPO_DOCUMENTO', '=', $tipo);
    	}

    }

}
