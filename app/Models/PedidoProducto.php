<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    use HasFactory;

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
