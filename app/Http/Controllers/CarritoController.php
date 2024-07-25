<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{



    public function obtenerCarrito()
    {

        try {
            $productosEnCarrito = Carrito::with('producto')->get();

            return response()->json(['productos' => $productosEnCarrito]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }

    public function addAlCarrito(Request $request, $productId)
    {
        try {
            $producto = Producto::find($productId);

            $cantidadSolicitada = $request->input('cantidad');
            if ($cantidadSolicitada <= 0 || $cantidadSolicitada > $producto->stock) {
                return response()->json(['error' => 'Cantidad no válida']);
            }

            $carritoItem = Carrito::where('codProducto', $producto->id)->first();

            if ($cantidadSolicitada <= $producto->stock) {
                if ($carritoItem) {

                        $carritoItem->cantidad += $cantidadSolicitada;
                        $carritoItem->save();
                } else {

                    $producto->stock -= $cantidadSolicitada;
                    $producto->save();

                    $carrito = new Carrito();
                    $carrito->codProducto = $producto->id;
                    $carrito->cantidad = $cantidadSolicitada;
                    $carrito->save();
                }
            }else{
                return response()->json(['error' => 'La cantidad solicitada es mayor al stock.'], 400);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function eliminarDelCarrito(Request $request, $productId) {
        try {
            $producto = Producto::find($productId);

            $cantidadSolicitada = $request->input('cantidad');
            if ($cantidadSolicitada <= 0 || $cantidadSolicitada > $producto->stock) {
                return response()->json(['error' => 'Cantidad no válida']);
            }

            $carritoItem = Carrito::where('codProducto', $producto->id)->first();

            if ($carritoItem) {

                if ($cantidadSolicitada <= $carritoItem->cantidad) {

                    $producto->stock += $cantidadSolicitada;
                    $producto->save();

                    $carritoItem->cantidad -= $cantidadSolicitada;
                    $carritoItem->save();

                    if ($carritoItem->cantidad == 0) {
                        $carritoItem->delete();
                    }

                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => 'La cantidad solicitada es mayor que la cantidad en el carrito.'], 400);
                }
            } else {
                return response()->json(['error' => 'El producto no está en el carrito.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}


