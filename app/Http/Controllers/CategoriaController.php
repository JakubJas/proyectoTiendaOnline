<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;


class CategoriaController extends Controller
{

    public function obtenerCategorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        return response()->json(['success' => true, 'message' => 'Categoría añadida correctamente.']);
    }

    public function update(Request $request, $categoriaId )
    {

        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        // Obtener la categoría
        $categoria = Categoria::find($categoriaId);

        // Verificar si la categoría existe
        if (!$categoria) {
            // Manejar el caso en que la categoría no existe
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Actualizar los datos de la categoría
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        // Redirigir o devolver una respuesta según tus necesidades
        return redirect()->route('priv')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Categoria $categoria)
    {

            $categoria = Categoria::with('productos')->find($categoria->id);

            foreach ($categoria->productos as $producto) {
                $producto->delete();
            }

            $categoria->delete();

            return response()->json(['success' => true, 'message' => 'Categoría eliminada correctamente.']);
        }

}
