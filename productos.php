<?php
session_start();
include('funciones.php');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Conexión a la base de datos
$conexion = conectarBD();

// Filtro de marca (si existe)
$marca_filtrada = isset($_GET['marca']) ? $_GET['marca'] : '';

// Obtener las marcas disponibles para el filtro
$query_marcas = "SELECT * FROM Marcas";
$resultado_marcas = $conexion->query($query_marcas);

// Obtener los productos filtrados por marca
$query_productos = "SELECT p.ProductoID, p.Nombre AS ProductoNombre, p.Descripcion, p.Precio, p.Stock, m.Nombre AS MarcaNombre 
                    FROM Productos p
                    JOIN Marcas m ON p.MarcaID = m.MarcaID" . 
    ($marca_filtrada ? " WHERE m.Nombre = '$marca_filtrada'" : "");
$resultado_productos = $conexion->query($query_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos en Stock</title>
    <link rel="stylesheet" href="CSS/estilosProd.css">
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
    <!-- Contenido de la página -->
    <div class="container">
        <!-- Filtros -->
        <div class="filters">
            <h2>Filtros</h2>
            <ul>
                <li><a href="productos.php">Ver todos</a></li>
                <?php while ($marca = $resultado_marcas->fetch_assoc()) { ?>
                    <li><a href="productos.php?marca=<?php echo $marca['Nombre']; ?>"><?php echo $marca['Nombre']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Productos -->
        <div class="productos">
            <h2>Productos en Stock</h2>
            <div class="productos-lista">
                <?php if ($resultado_productos->num_rows > 0) { 
                    while ($producto = $resultado_productos->fetch_assoc()) { ?>
                        <div class="producto">
                            <h3><?php echo $producto['ProductoNombre']; ?></h3>
                            <p><?php echo $producto['Descripcion']; ?></p>
                            <p><strong>Precio:</strong> $<?php echo number_format($producto['Precio'], 2); ?></p>
                            <p><strong>Stock:</strong> <?php echo $producto['Stock']; ?></p>
                            <p><strong>Marca:</strong> <?php echo $producto['MarcaNombre']; ?></p>
                        </div>
                <?php } 
                } else {
                    echo "<p>No se encontraron productos.</p>";
                } ?>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>

