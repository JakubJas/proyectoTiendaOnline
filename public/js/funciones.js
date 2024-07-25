function login() {
    const usuario = $('#usuario').val();
    const clave = $('#clave').val();

    // realiza la solicitud AJAX
    $.ajax({
        url: '/login',
        type: 'POST',
        data: {
            usuario: usuario,
            clave: clave,
            _token: $('meta[name="csrf-token"]').attr('content') // agrega el token CSRF
        },
        dataType: 'json',
        success: function (response) {
            // maneja la respuesta del servidor
            if (response.success) {
                // redirige al usuario después de iniciar sesión correctamente
                window.location.href = '/Principal';
            } else {
                // muestra un mensaje de error si la autenticación falla
                alert(response.message);
            }
        },
        error: function (error) {
            console.error('Error al intentar iniciar sesión:', error);
        }
    });
}

// asigna el evento al botón de inicio de sesión
$(document).ready(function () {
    $('#loginBtn').on('click', function (event) {
        event.preventDefault();
        login(); // llama a la función de inicio de sesión
    });
});

/**
 * CATEGORIA
 */

function cargarCategorias() {
    $('#contenedorCategorias').show();
    $('#editCatego').hide();
    $('#añadirCate').hide();

    $('#contenedorProductos').hide();
    $('#añadirPro').hide();

    $('#contenedoraCarrito').hide();


    $('#finComp').hide();

    $.ajax({
        url: '/obtenerCategorias',
        type: 'GET',
        dataType: 'json',
        success: function (categorias) {
            const tablaCategorias = $('#tablaCategorias tbody');
            tablaCategorias.empty();

            categorias.forEach(categoria => {
                const fila = `<tr>
                    <td>${categoria.nombre}</td>
                    <td>${categoria.descripcion}</td>
                    <td>
                        <button id="verProductos" class="verProductos tambtn btn btn-primary btn-lg" data-categoria-id="${categoria.id}">Ver productos</button>

                        <button class="editCate tambtn btn btn-primary btn-lg" data-categoria-id="${categoria.id}"
                        data-categoria-nombre="${categoria.nombre}"
                        data-categoria-descripcion="${categoria.descripcion}">Editar</button>

                        <button id="eraseCate" class="tambtn tambtn btn btn-danger btn-lg" data-categoria-id="${categoria.id}">Eliminar</button>
                    </td>
                </tr>`;
                tablaCategorias.append(fila);
            });
        },
        error: function (error) {
            console.error('Error al obtener categorías:', error);
        }
    });
}

$(document).on('click', '#menuVerCategorias', function (event) {
    event.preventDefault();
    cargarCategorias();
});



$(document).on('click', '#menuAñadirCategoria', function () {
    $('#contenedorCategorias').hide();
    $('#editCatego').hide();
    $('#añadirCate').show();

    $('#contenedorProductos').hide();
    $('#añadirPro').hide();

    $('#contenedoraCarrito').hide();

    $('#finComp').hide();

});

$(document).ready(function() {
    $('#categoriaForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                alert("Categoria añadida correctamente");

            },
            error: function(response) {
                alert('Se produjo un error, no se pudo añadir Categoría.');

            }
        });
    });
});

$(document).on('click', '#eraseCate', function () {
    const categoriaId = $(this).data('categoria-id');
    const token = $('meta[name="csrf-token"]').attr('content');

    if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        $.ajax({
            type: 'DELETE',
            url: '/eliminarCategoria/' + categoriaId,
            data: {
                '_token': token
            },
            dataType: 'json',
            success: function(response) {
                alert("Categoria borrada correctamente");
                cargarCategorias();
            },
            error: function(response) {
                alert('Se produjo un error, no se pudo eliminar la Categoría');
            }
        });
    }
});

$(document).on('click', '.editCate', function () {
    const categoriaId = $(this).data('categoria-id');
    const categoriaNombre = $(this).data('categoria-nombre');
    const categoriaDescripcion = $(this).data('categoria-descripcion');

    console.log('Categoria ID:', categoriaId);
    console.log('Categoria Nombre:', categoriaNombre);
    console.log('Categoria Descripcion:', categoriaDescripcion);

    $('#contenedorCategorias').hide();
    $('#editCatego').show();
    $('#añadirCate').hide();

    $('#contenedorProductos').hide();
    $('#añadirPro').hide();

    $('#contenedoraCarrito').hide();
});

$(document).on('click', '#editBtnCate', function () {
    const token = $('meta[name="csrf-token"]').attr('content');
    const categoriaId = $(this).data('categoria-id');

    if (confirm('¿Estás seguro de que deseas editar esta categoría?')) {
        $.ajax({
            type: 'PUT',
            url: '/editarCategoria/' + categoriaId,
            data: {
                '_token': token
            },
            dataType: 'json',
            success: function(response) {
                alert("Categoria editada correctamente");
                cargarCategorias();
            },
            error: function(response) {
                alert('Se produjo un error, no se pudo editar la Categoría');
            }
        });
    }
});


/**
 * PRODUCTOS
 */

function cargarProductos(categoriaId) {
    console.log('Categoría ID:', categoriaId);


    $('#contenedorCategorias').hide();
    $('#editCatego').hide();
    $('#añadirCate').hide();

    $('#contenedorProductos').show();
    $('#añadirPro').hide();


    $('#contenedoraCarrito').hide();

    $.ajax({
        url: '/obtenerProductosPorCategoria/' + categoriaId,

        type: 'GET',
        dataType: 'json',
        success: function (productos) {
            console.log('Respuesta del servidor:', productos);

            const tablaProductos = $('#tablaProductos tbody');
            tablaProductos.empty();

            productos.forEach(producto => {
                const fila = `<tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.descripcion}</td>
                    <td>${producto.stock}</td>
                    <td>
                        <input type="number" min="1" class="cantidadProducto">
                        <button class="addPro tambtn btn btn-primary btn-lg" data-producto-id="${producto.id}"
                            data-producto-nombre="${producto.nombre}"
                            data-producto-descripcion="${producto.descripcion}"
                            data-producto-stock="${producto.stock}">Añadir
                        </button>
                        <button id="erasePro" class="eliminarPro tambtn btn btn-danger btn-lg" data-producto-id="${producto.id}">Eliminar</button>
                    </td>
                </tr>`;
                tablaProductos.append(fila);
            });
        },
        error: function (error) {
            console.error('Error al obtener productos por categoría:', error);
        }
    });
}

$(document).on('click', '#verProductos', function (event) {
    event.preventDefault();
    const categoriaId = $(this).data('categoria-id'); 
    cargarProductos(categoriaId);

});

$(document).on('click', '#erasePro', function () {
    const productoId = $(this).data('producto-id');
    const token = $('meta[name="csrf-token"]').attr('content');

    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        $.ajax({
            type: 'DELETE',
            url: '/eliminarProducto/' + productoId,
            data: {
                '_token': token
            },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                cargarProductos();
            },
            error: function(response) {
                alert('Se produjo un error, no se pudo eliminar el producto de la Categoría');
            }
        });
    }
});

$(document).on('click', '#menuProducto', function () {
    $('#contenedorCategorias').hide();
    $('#editCatego').hide();
    $('#añadirCate').hide();

    $('#contenedorProductos').hide();
    $('#añadirPro').show();

    $('#contenedoraCarrito').hide();

    $('#finComp').hide();
});

$(document).ready(function() {
    $('#productoForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                alert('Producto añadido con exito: ' + response.message);
                cargarProductos();
            },
            error: function(response) {
                alert('Se produjo un error, no se pudo añadir Producto.');

            }
        });
    });
});

/**
 * CARRITO
 */

function cargarCarrito() {
    $('#contenedorCategorias').hide();
    $('#añadirCate').hide();
    $('#editCatego').hide();

    $('#contenedorProductos').hide();
    $('#añadirPro').hide();

    $('#contenedoraCarrito').show();

    $('#finComp').hide();

    $.ajax({
        url: '/obtenerCarrito',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            const tablaCarrito = $('#tablaCarrito tbody');
            tablaCarrito.empty();

            if (response.productos.length === 0) {
                $('#mensajeCarritoVacio').text('El carrito está vacío').show();
                $('#checkOut').hide();
                return;
            }

            $('#mensajeCarritoVacio').hide();
            $('#checkOut').show();

            response.productos.forEach(item => {
                if (item.producto) {
                    const fila = `<tr>
                        <td>${item.producto.id}</td>
                        <td>${item.producto.nombre}</td>
                        <td>${item.producto.descripcion}</td>
                        <td>${item.cantidad}</td>
                        <td>
                            <input type="number" min="1" class="cantidadElimiarProducto">
                            <button class="eliminarProducto tambtn btn btn-danger btn-lg"
                            data-producto-id="${item.producto.id}"
                            data-producto-id="${item.producto.nombre}"
                            data-producto-id="${item.producto.descripcion}"
                            data-producto-id="${item.cantidad}">Eliminar</button>
                        </td>
                    </tr>`;
                    tablaCarrito.append(fila);

                }else{
                    console.error('No se puede cargar los productos');
                }

            });
        },
        error: function (error) {
            console.error('Error al obtener el carrito:', error);
        }
    });

}

$(document).on('click', '#menuCarrito', function (event) {
    event.preventDefault();
    cargarCarrito();
});

$(document).on('click', '.addPro', function () {
    const productoId = $(this).data('producto-id');
    const productoNombre = $(this).data('producto-nombre');
    const productoStock = $(this).data('producto-stock');
    const cantidadInput = $(this).closest('tr').find('.cantidadProducto');
    const cantidad = cantidadInput.val();

    console.log('Añadiendo al carrito:');
    console.log('Producto ID:', productoId);
    console.log('Nombre:', productoNombre);
    console.log('Stock:', productoStock);
    console.log('Cantidad:', cantidad);

    console.log('Token CSRF:', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: '/addAlCarrito/' + productoId,
        type: 'POST',
        dataType: 'json',
        data: { cantidad: cantidad, _token: '{{ csrf_token() }}'},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            cargarProductos();
        },
        error: function (error) {
            console.error('Error al añadir producto al carrito:', error.responseJSON.error);
        }
    });

});

$(document).on('click', '.eliminarProducto', function () {
    const productoId = $(this).data('producto-id');
    const cantidadInput = $(this).closest('tr').find('.cantidadElimiarProducto');
    const cantidad = cantidadInput.val();

    console.log('Eliminando del carrito:');
    console.log('Producto ID:', productoId);
    console.log('Cantidad:', cantidad);

    if (cantidad === undefined || cantidad.trim() === '') {
        alert('Por favor, introduce una cantidad válida.');
        return;
    }

    if (isNaN(cantidad) || cantidad <= 0) {
        alert('La cantidad debe ser un número positivo mayor que cero.');
        return;
    }

    $.ajax({
        url: '/eliminarDelCarrito/' + productoId,
        type: 'DELETE',
        dataType: 'json',
        data: { cantidad: cantidad, _token: '{{ csrf_token() }}'},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            cargarCarrito();
            alert('Producto eliminado correctamente');
        },
        error: function (error) {
            console.error('Error al eliminar producto del carrito:', error.responseJSON.error);
            alert('Error: ' + error.responseJSON.error);
        }
    });
});

/**
 * PEDIDO
 */

$(document).on('click', '#checkOut', function (){
    const usuarioId = $('#checkOut').data('usuario-id');

    $('#contenedorCategorias').hide();
    $('#añadirCate').hide();
    $('#editCatego').hide();

    $('#contenedorProductos').hide();
    $('#añadirPro').hide();

    $('#contenedoraCarrito').hide();

    $('#finComp').show();

    console.log(usuarioId);

    $.ajax({
        url: '/finalizarPedido/' + usuarioId,
        type: 'GET',
        dataType: 'json',
        data: { _token: '{{ csrf_token() }}' },
        success: function (response) {
            console.log(response);
            cargarCarrito();
            alert('Pedido realizado con éxito');
        },
        error: function (error) {
            console.error('Error al finalizar pedido:', error.responseJSON.error);
        }
    });

});



