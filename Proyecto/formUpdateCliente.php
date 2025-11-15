<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\Cliente;

// === SEGURIDAD ===
if (!isset($_SESSION['user_name']) || !isset($_GET['numero'])) {
    header('Location: index.php');
    exit;
}

$numeroCliente = (int)$_GET['numero'];
$cliente = null;

// Buscar cliente
if (isset($_SESSION['clientes'])) {
    foreach ($_SESSION['clientes'] as $c) {
        if ($c->getNumero() === $numeroCliente) {
            $cliente = $c;
            break;
        }
    }
}

if (!$cliente) {
    $_SESSION['error_cliente'] = 'Cliente no encontrado.';
    header('Location: mainAdmin.php');
    exit;
}

// Comprobar permisos
$esAdmin = ($_SESSION['role'] ?? '') === 'admin';
$esPropietario = ($_SESSION['user_name'] ?? '') === $cliente->getUser();

if (!$esAdmin && !$esPropietario) {
    $_SESSION['error_login'] = 'No tienes permiso para editar este cliente.';
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        label { display: block; margin: 15px 0 5px; font-weight: bold; }
        input[type="text"], input[type="password"], input[type="number"] {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;
        }
        button { background: #007bff; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 20px; }
        button:hover { background: #0056b3; }
        .back { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back:hover { text-decoration: underline; }
        .error { color: red; background: #ffe6e6; padding: 10px; border-radius: 4px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= $esAdmin ? 'mainAdmin.php' : 'mainCliente.php' ?>" class="back">Volver</a>
        <h1>Editar Cliente #<?= $cliente->getNumero() ?></h1>

        <?php if (isset($_SESSION['error_cliente'])): ?>
            <div class="error"><?= htmlspecialchars($_SESSION['error_cliente']) ?></div>
            <?php unset($_SESSION['error_cliente']); ?>
        <?php endif; ?>

        <form action="updateCliente.php" method="POST">
            <input type="hidden" name="numero" value="<?= $cliente->getNumero() ?>">

            <label>Nombre completo:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($cliente->getNombre()) ?>" required>

            <label>Usuario (login):</label>
            <input type="text" name="usuario" value="<?= htmlspecialchars($cliente->getUser()) ?>" required>

            <label>Nueva contraseña (dejar en blanco para no cambiar):</label>
            <input type="password" name="password" placeholder="Solo si deseas cambiarla">

            <label>Máx. alquileres simultáneos:</label>
            <input type="number" name="maxAlquileres" min="1" max="10" value="<?= $cliente->maxAlquilerConcurrente ?? 3 ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>