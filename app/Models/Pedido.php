<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'id',
        //codCliente
        'fecha',
    ];

    /*public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'codCliente');
    }*/

    public function productos()
    {
        return $this->hasMany(PedidoProducto::class, 'pedido_id');
    }
}
