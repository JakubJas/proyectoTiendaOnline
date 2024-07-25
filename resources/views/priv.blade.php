<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/funciones.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/addCate.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    <style>
        #mensajeCarritoVacio {
            display: flex;
            justify-content: center;
            height: 10vh;
            color: red;
        }
    </style>
</head>
<body>

    @php
        $usuario = \App\Models\Usuario::find(1);
    @endphp

    Usuario: {{$usuario->usuario}}

    @include('Cabecera')


    <div id="tituloLibros">
        <h1></h1>
    </div>

    <div id="contenedorCategorias" style="display:none;">
        <h1>Lista de Categorías</h1>
        <table id="tablaCategorias" class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div id="contenedorProductos" style="display:none;">
        <h1>Lista de Productos</h1>
        <table id="tablaProductos" class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div id="añadirCate" style="display:none;">

        <form method="POST" action="{{ route('crear.categoria') }}" id="categoriaForm">
            @csrf

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">
                </div>

                <div class="form-group col-md-6">
                    <label for="descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="">
                </div>

                <br>
                <button type="submit" id="addBtnCate" class="btn btn-primary">Añadir</button>
            </div>
        </form>

    </div>

    @php
        $categorias = \App\Models\Categoria::all();
    @endphp

    <div id="añadirPro" style="display:none;">

        <form method="POST" action="{{ route('crear.producto.store') }}" id="productoForm">
            @csrf

            <div class="form-group col-md-6">
                <label for="nombreProducto">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="">
            </div>

            <div class="form-group col-md-6">
                <label for="categoria">Categoría:</label>
                <select class="form-control" id="categoria" name="categoria">
                    @isset($categorias)
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                        @endforeach
                        @else
                        <option value="">No hay categorías disponibles</option>
                    @endisset
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="stock">Cantidad:</label>
                <input type="number" min="1" class="form-control" id="stock" name="stock" value="">
            </div>

            <div class="form-group col-md-6">
                <label for="descripcionProducto">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="">
            </div>

            <br>
            <button type="submit" id="addBtnProducto" class="btn btn-primary">Añadir</button>

        </form>
    </div>

    <div id="editCatego" style="display:none;">

        <form method="POST" action="{{ route('editar.categoria', ['categoriaId' => $categoria->id]) }}" id="categoriaEditForm">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $categoria->nombre }}">
                </div>

                <div class="form-group col-md-6">
                    <label for="descripcion">Descripcion:</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $categoria->descripcion }}">
                </div>

                <br>
                <button type="submit" id="editBtnCate" class="btn btn-primary">Actualizar</button>
            </div>
        </form>

    </div>

    <div id="contenedoraCarrito" style="display:none;">
        <h1>Carrito</h1>

        <h3 id="mensajeCarritoVacio" style="display: none;"></h3>

        <table id="tablaCarrito" class="table">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Unidades</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button id="checkOut" style="display: none;">Realizar pedido</button>
    </div>


    <div id="finComp" style="display: none;">
        <h1>Estado del pedido</h1>
        <p>Pedido realizado!!!</p>
    </div>
</body>
</html>
