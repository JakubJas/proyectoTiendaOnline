<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito';

    protected $fillable = ['codProducto', 'cantidad'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codProducto');
    }

}
