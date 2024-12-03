<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Incluye tu archivo de conexión a la base de datos
include('funciones.php');

// Conexión a la base de datos
$conexion = conectarBD();

// Consulta para obtener productos con stock
$sql = "SELECT ProductoID, Nombre, Descripcion, Precio, Stock FROM Productos WHERE Stock > 0";
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link rel="stylesheet" href="CSS/estilosVentas.css">
    <script src="scriptVentas.js"></script>
</head>
<body>
    
 <!-- Barra de navegación -->
 <nav class="navbar">
    <ul class="nav-links">
        <!-- Botón HOME -->
        <li class="nav-item">
            <a href="home.php">Home</a> <!-- Cambia el href según la ruta de tu página principal -->
        </li>

        <li class="nav-item">
            <a href="productos.php">Productos</a>
            <ul class="dropdown">
                <li><a href="#">Ver Productos</a></li>
                <li><a href="#">Cargar Producto</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#">Marcas</a>
            <ul class="dropdown">
                <li><a href="#">Ver Marcas</a></li>
                <li><a href="#">Cargar Marca</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#">Usuarios</a>
            <ul class="dropdown">
                <li><a href="#">Ver Usuarios</a></li>
                <li><a href="#">Agregar Usuario</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="ventas.php">Ventas</a>
            <ul class="dropdown">
                <li><a href="#">Ver Ventas</a></li>
                <li><a href="#">Nueva Venta</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#">Facturas</a>
            <ul class="dropdown">
                <li><a href="#">Ver Facturas</a></li>
                <li><a href="#">Generar Factura</a></li>
            </ul>
        </li>
        <li class="nav-item"><a href="#">Mis Datos</a></li>
        <li class="nav-item"><a href="logout.php">Cerrar sesión</a></li>
    </ul>
</nav>

    <h1>Productos en Stock</h1>
    <input type="text" id="buscar" onkeyup="filtrarProductos()" placeholder="Buscar producto...">

    <div class="container">
        <!-- Tabla de productos en stock -->
        <div class="table-container">
            <h2>Productos en Stock</h2>
            <table id="tablaStock">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar productos en stock
                    if ($result->num_rows > 0) {
                        while ($producto = $result->fetch_assoc()) {
                            echo "<tr class='producto' data-nombre='" . strtolower($producto['Nombre']) . "'>";
                            echo "<td>" . $producto['Nombre'] . "</td>";
                            echo "<td>" . $producto['Descripcion'] . "</td>";
                            echo "<td>" . number_format($producto['Precio'], 2) . "</td>";
                            echo "<td>" . $producto['Stock'] . "</td>";
                            echo "<td><button onclick=\"agregarProducto({$producto['ProductoID']}, '{$producto['Nombre']}', {$producto['Precio']})\">Agregar</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay productos disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de productos agregados para la venta -->
        <div class="table-container">
            <h2>Carro de compras</h2>
            <table id="tablaVenta">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="productosVenta">
                    <!-- Aquí se llenarán los productos agregados -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>




