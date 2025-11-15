<?php
require_once "autoload.php";
session_start();
ob_start();

// Solo admin puede acceder
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error_login'] = 'Acceso no autorizado.';
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Cliente</title>
    <style>
        .error {
            color: red;
        }

        .container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
        }

        input,
        button {
            margin: 0.5rem 0;
            padding: 0.5rem;
            width: 100%;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="mainAdmin.php">← Volver al Panel</a>
        <h1>Crear Nuevo Cliente</h1>

        <?php if (isset($_SESSION['error_cliente'])): ?>
            <p class="error"><?php echo htmlspecialchars($_SESSION['error_cliente']);
                                unset($_SESSION['error_cliente']); ?></p>
        <?php endif; ?>

        <form action="createCliente.php" method="POST">
            <label>Nombre completo:</label>
            <input type="text" name="nombre" required value="<?php echo $_SESSION['old_nombre'] ?? '';
                                                                unset($_SESSION['old_nombre']); ?>">

            <label>Usuario (login):</label>
            <input type="text" name="usuario" required value="<?php echo $_SESSION['old_usuario'] ?? '';
                                                                unset($_SESSION['old_usuario']); ?>">

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <label>Máximo alquileres simultáneos:</label>
            <input type="number" name="maxAlquileres" min="1" max="10" value="3" required>

            <button type="submit">Crear Cliente</button>
        </form>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>