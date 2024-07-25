<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario',
        'clave',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'codCliente');
    }
}





