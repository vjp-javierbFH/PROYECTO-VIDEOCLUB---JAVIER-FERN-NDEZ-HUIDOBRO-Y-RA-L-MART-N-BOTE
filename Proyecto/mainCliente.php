<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Soporte;

if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'cliente' || !isset($_SESSION['cliente_data'])) {
    $_SESSION['error_login'] = 'Acceso no autorizado.';
    header('Location: index.php');
    ob_end_flush();
    exit;
}

$userName = $_SESSION['user_name'];
$cliente = unserialize($_SESSION['cliente_data']); /* @var $cliente Cliente */

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Videoclub - Panel de Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logout {
            float: right;
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }

        .logout:hover {
            text-decoration: underline;
        }

        h1 {
            color: #343a40;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .welcome {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            font-size: 1.1em;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin: 15px 0;
            font-weight: bold;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin: 15px 0;
        }

        .edit-link {
            margin-left: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        hr {
            border: 0;
            border-top: 1px solid #eee;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="logout.php" class="logout">Cerrar Sesión</a>
        <h1>Videoclub - Panel de Cliente</h1>

        <!-- Mensaje de éxito -->
        <?php if (isset($_SESSION['exito_cliente'])): ?>
            <div class="success">
                <?= htmlspecialchars($_SESSION['exito_cliente']) ?>
                <?php unset($_SESSION['exito_cliente']); ?>
            </div>
        <?php endif; ?>

        <!-- Mensaje de error (si viene del login) -->
        <?php if (isset($_SESSION['error_login'])): ?>
            <div class="error">
                <?= htmlspecialchars($_SESSION['error_login']) ?>
                <?php unset($_SESSION['error_login']); ?>
            </div>
        <?php endif; ?>

        <div class="welcome">
            Bienvenido, <strong><?= htmlspecialchars($userName) ?></strong>.
            Tienes <strong><?= $cliente->getNumSoporteAlquilado() ?></strong> alquiler(es) activo(s).
            <a href="formUpdateCliente.php?numero=<?= $cliente->getNumero() ?>" class="edit-link">
                Editar Perfil
            </a>
        </div>

        <h2>Mis Alquileres Actuales</h2>
        <?php
        $alquileres = $cliente->getAlquileres();
        if (empty($alquileres)) {
            echo "<p style='color: #6c757d; font-style: italic;'>No tienes alquileres activos.</p>";
        } else {
            foreach ($alquileres as $soporte): /* @var $soporte Soporte */ ?>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 10px 0; border-left: 4px solid #007bff;">
                    <?php
                    $soporte->muestraResumen();
                    echo "<br><strong>Precio (IVA incl.): " . number_format($soporte->getPrecioConIva(), 2) . " €</strong>";
                    ?>
                </div>
                <hr>
        <?php endforeach;
        }
        ?>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>