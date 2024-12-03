<?php
session_start();
include('funciones.php');

// Conexión a la base de datos
$conexion = conectarBD();

// Obtener el término de búsqueda desde los parámetros de la solicitud
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Consulta base para productos en stock
$sql = "SELECT p.ProductoID AS prod_id, 
               p.Nombre AS prod_nombre, 
               p.Precio AS prod_precio, 
               p.Stock AS prod_stock, 
               m.Nombre AS prod_marca 
        FROM Productos p
        JOIN Marcas m ON p.MarcaID = m.MarcaID
        WHERE p.Stock > 0";

// Si hay un término de búsqueda, aplica el filtro
if (!empty($query)) {
    $sql .= " AND (p.Nombre LIKE ? OR m.Nombre LIKE ?)";
}

$stmt = $conexion->prepare($sql);

if (!empty($query)) {
    $likeQuery = "%$query%";
    $stmt->bind_param("ss", $likeQuery, $likeQuery);
}

$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

// Devolver los resultados como JSON
echo json_encode($productos);
?>





