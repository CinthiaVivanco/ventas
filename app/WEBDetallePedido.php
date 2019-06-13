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

    public function producto()
    {
        return $this->belongsTo('App\ALMProducto', 'producto_id', 'COD_PRODUCTO');
    }
    public function pedido()
    {
        return $this->belongsTo('App\WEBPedido', 'pedido_id', 'id');
    }


}
