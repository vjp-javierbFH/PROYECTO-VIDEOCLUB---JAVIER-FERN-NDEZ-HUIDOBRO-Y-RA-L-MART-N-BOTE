<?php
session_start();
// Iniciar buffer de salida para evitar problemas de cabeceras
ob_start();

// Borrar el error si existe en la sesión para que no se muestre al recargar
$error = null;
if (isset($_SESSION['error_login'])) {
    $error = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}

// Redireccionar si ya está logueado
if (isset($_SESSION['user_name'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: mainAdmin.php');
    } elseif (isset($_SESSION['cliente_data'])) {
        header('Location: mainCliente.php');
    } else {
        header('Location: main.php');
    }
    ob_end_flush();
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Videoclub - Iniciar Sesión</title>
</head>
<body>
    <div class="login-container">
        <h1>Acceso al Videoclub</h1>
        
        <?php if ($error): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div>
                <label for="user">Usuario:</label>
                <input type="text" id="user" name="user" required>
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>

        <div class="info">
            <p>Usuarios de prueba:</p>
            <p>Admin: <strong>admin / admin</strong></p>
            <p>Cliente: <strong>usuario / usuario</strong></p>
            <p>Cliente: <strong>bruce / batman</strong></p>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>