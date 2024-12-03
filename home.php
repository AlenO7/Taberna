<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema de Ventas</title>
    <link rel="stylesheet" href="CSS/estilosHome.css">
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



    <!-- Contenido principal -->
    <div class="main-content">
        <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?>!</h1>
        <div class="buttons">
            <button class="btn" onclick="window.location.href='ventas.php'">Nueva Venta</button>
            <button class="btn" onclick="window.location.href='cargar_producto.php'">Cargar Productos</button>
        </div>
    </div>
</body>
</html>
<script src="script.js"></script>


