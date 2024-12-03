<?php
session_start();

// Incluir las funciones desde el archivo funciones.php
require_once('funciones.php');

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Llamar a la función para validar las credenciales del usuario
    $resultado = validarUsuario($correo, $contraseña);

    // Si la validación fue exitosa (retorna un arreglo con los datos del usuario)
    if (is_array($resultado)) {
        // Almacenar los datos del usuario en la sesión
        $_SESSION['usuario_id'] = $resultado['UsuarioID'];
        $_SESSION['usuario_nombre'] = $resultado['Nombre'];
        $_SESSION['usuario_rol'] = $resultado['Rol'];
        $_SESSION['usuario_correo'] = $resultado['Correo'];

        // Redirigir al home
        header('Location: home.php');
        exit();
    } else {
        // Si la validación falla, redirigir a login con el mensaje de error
        header('Location: index.php?error=' . urlencode($resultado));
        exit();
    }
}
?>


