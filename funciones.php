<?php
// Función para conectar a la base de datos
function conectarBD() {
    $host = 'localhost';
    $usuario = 'root';
    $contraseña = '';
    $base_de_datos = 'SistemaTaberna';

    // Crear la conexión
    $conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

    // Verificar si hay errores en la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    return $conexion;
}

// Función para validar las credenciales del usuario (sin encriptación)
function validarUsuario($correo, $contraseña) {
    // Conectamos a la base de datos
    $conexion = conectarBD();

    // Preparamos la consulta para verificar el usuario
    $consulta = "SELECT * FROM Usuarios WHERE Correo = ?";
    $stmt = $conexion->prepare($consulta);

    // Verificamos si la preparación de la consulta fue exitosa
    if (!$stmt) {
        return 'Error en la consulta: ' . $conexion->error;
    }

    // Vinculamos los parámetros de la consulta
    $stmt->bind_param('s', $correo);
    
    // Ejecutamos la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificamos si el resultado contiene filas (si el correo existe)
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificamos si la contraseña coincide (sin encriptación)
        if ($contraseña === $usuario['Contraseña']) {
            // La contraseña es correcta, devolvemos los datos del usuario
            return $usuario;
        } else {
            return 'Contraseña incorrecta'; // La contraseña no coincide
        }
    } else {
        return 'Correo no registrado'; // No se encuentra el correo en la base de datos
    }

    // Cerramos la consulta y la conexión
    $stmt->close();
    $conexion->close();
}

function mostrarProductosEnStock() {
    global $result;

    // Verifica si hay productos
    if ($result->num_rows > 0) {
        while($producto = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $producto['Nombre'] . "</td>
                    <td>" . $producto['Descripcion'] . "</td>
                    <td>" . number_format($producto['Precio'], 2) . "</td>
                    <td>" . $producto['Stock'] . "</td>
                    <td>
                        <button onclick=\"agregarProducto({$producto['ProductoID']}, '{$producto['Nombre']}', {$producto['Precio']})\">Agregar</button>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hay productos en stock</td></tr>";
    }
}
?>





