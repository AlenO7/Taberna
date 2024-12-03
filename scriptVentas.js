let productosSeleccionados = [];
let totalVenta = 0;

// Array para almacenar los productos agregados
let productosVenta = [];

// Función para agregar productos al carrito de venta
function agregarProducto(id, nombre, precio) {
    // Verificar si el producto ya está en el carrito
    let productoExistente = productosVenta.find(p => p.id === id);
    
    if (productoExistente) {
        productoExistente.cantidad += 1; // Si existe, aumentar la cantidad
        productoExistente.total = productoExistente.cantidad * productoExistente.precio;
    } else {
        // Si no existe, agregarlo al array
        productosVenta.push({
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: 1,
            total: precio
        });
    }

    // Actualizar la tabla de productos para la venta
    actualizarTablaVenta();
}

// Función para actualizar la tabla de productos para la venta
function actualizarTablaVenta() {
    const tablaVenta = document.getElementById('productosVenta');
    tablaVenta.innerHTML = ''; // Limpiar la tabla antes de actualizarla

    productosVenta.forEach(producto => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${producto.nombre}</td>
            <td>${producto.precio.toFixed(2)}</td>
            <td>${producto.cantidad}</td>
            <td>${producto.total.toFixed(2)}</td>
            <td><button onclick="eliminarProducto(${producto.id})">Eliminar</button></td>
        `;
        tablaVenta.appendChild(fila);
    });
}

// Función para eliminar un producto de la venta
function eliminarProducto(id) {
    productosVenta = productosVenta.filter(p => p.id !== id);
    actualizarTablaVenta();
}


// Finalizar venta
function finalizarVenta() {
    fetch('procesar_venta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ productos: productosSeleccionados, total: totalVenta })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        productosSeleccionados = [];
        actualizarTabla();
    });
}

// Buscar productos en la base de datos
function buscarProducto() {
    const query = document.getElementById('buscar').value;

    fetch(`buscar_productos.php?query=${query}`)
        .then(response => response.json())
        .then(data => {
            const tablaStock = document.getElementById('tablaStock');
            tablaStock.innerHTML = '';

            data.forEach(producto => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${producto.Nombre}</td>
                    <td>${producto.Marca}</td>
                    <td>${producto.Precio.toFixed(2)}</td>
                    <td>${producto.Stock}</td>
                    <td>
                        <button onclick="agregarProducto(${producto.ProductoID}, '${producto.Nombre}', '${producto.Marca}', ${producto.Precio})">
                            Agregar
                        </button>
                    </td>
                `;
                tablaStock.appendChild(row);
            });
        });
}

// Cargar todos los productos en stock al iniciar
document.addEventListener('DOMContentLoaded', buscarProducto);

// Función para filtrar los productos
function filtrarProductos() {
    const query = document.getElementById('buscar').value.toLowerCase(); // Obtener el valor del buscador
    const productos = document.querySelectorAll('#tablaStock tbody tr'); // Obtener todas las filas de la tabla

    productos.forEach(producto => {
        const nombreProducto = producto.getAttribute('data-nombre'); // Obtener el nombre del producto en minúsculas
        if (nombreProducto.includes(query)) {
            producto.style.display = ''; // Si el nombre del producto coincide con la búsqueda, lo mostramos
        } else {
            producto.style.display = 'none'; // Si no coincide, lo ocultamos
        }
    });
}

