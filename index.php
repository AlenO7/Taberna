<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso al Sistema</title>
    <link rel="stylesheet" href="CSS/estilos.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <!-- Mostrar el mensaje de error si existe -->
        <?php if (isset($_GET['error'])) { echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>"; } ?>
        <form method="POST" action="login.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>


