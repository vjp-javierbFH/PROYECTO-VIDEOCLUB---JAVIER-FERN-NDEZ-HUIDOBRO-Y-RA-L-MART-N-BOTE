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
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }

        .logout {
            float: right;
            color: red;
        }

        .welcome {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="logout.php" class="logout">Cerrar Sesión</a>
        <h1>Videoclub - Panel de Cliente</h1>

        <div class="welcome">
            Bienvenido, <strong><?= htmlspecialchars($userName) ?></strong>.
            Tienes <?= $cliente->getNumSoporteAlquilado() ?> alquiler(es) activo(s).
            <a href="formUpdateCliente.php?numero=<?= $cliente->getNumero() ?>"
                style="margin-left: 15px; color: #007bff; text-decoration: none;">
                Editar Perfil
            </a>
        </div>

        <h2>Mis Alquileres Actuales</h2>
        <?php
        $alquileres = $cliente->getAlquileres();
        if (empty($alquileres)) {
            echo "<p>No tienes alquileres activos.</p>";
        } else {
            foreach ($alquileres as $soporte) {
                $soporte->muestraResumen();
                echo "<br>Precio (IVA): " . number_format($soporte->getPrecioConIva(), 2) . " €<hr>";
            }
        }
        ?>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>