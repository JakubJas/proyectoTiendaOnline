<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function finalizarPedido($id)
    {
        try {
            /*$usuario = Usuario::find($id);

            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }*/

            $pedido = new Pedido();
            //$pedido->codCliente = $usuario->id;
            $pedido->fecha = now();
            $pedido->save();

            // Descomentar este bloque si es necesario

            $productosEnCarrito = Carrito::with('producto')->get();
            foreach ($productosEnCarrito as $carritoItem) {
                $pedidoProducto = new PedidoProducto();
                $pedidoProducto->pedido_id = $pedido->id;
                $pedidoProducto->producto_id = $carritoItem->codProducto;
                $pedidoProducto->save();
            }


            Carrito::truncate();

            return response()->json(['success' => true, 'message' => 'Pedido finalizado exitosamente']);
        }catch (\Exception $e) {
            dd($e);
            return response()->json(['success' => false, 'message' => 'Error al finalizar el pedido'], 500);
        }
    }
}
