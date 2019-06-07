<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBDetallePedido extends Model
{
    protected $table = 'WEB.detallepedidos';
    public $timestamps=false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

}
