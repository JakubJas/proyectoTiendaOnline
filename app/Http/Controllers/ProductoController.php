<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Log;


class ProductoController extends Controller
{
    public function obtenerProductosPorCategoria($categoriaId)
    {
        $productos = Producto::where('categoria_id', $categoriaId)->get();
        return response()->json($productos);
    }


    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'categoria' => 'required',
            'stock' => 'required',
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->categoria_id = $request->categoria;
        $producto->save();

        return response()->json(['success' => true, 'message' => 'Producto añadido exitosamente.']);
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if ($producto) {
            $producto->delete();
            return response()->json(['success' => true, 'message' => 'Producto eliminado exitosamente.']);
        } else {
            return response()->json(['success' => false, 'message' => 'El producto no existe.']);
        }
    }

}

