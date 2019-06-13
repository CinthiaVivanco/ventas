<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WEBPedido extends Model
{
    protected $table = 'WEB.pedidos';
    public $timestamps=false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';


    public function empresa()
    {
        return $this->belongsTo('App\STDEmpresa', 'cliente_id', 'COD_EMPR');
    }

    public function detallepedido()
    {
        return $this->hasMany('App\WEBDetallePedido', 'pedido_id', 'id');
    }
}
