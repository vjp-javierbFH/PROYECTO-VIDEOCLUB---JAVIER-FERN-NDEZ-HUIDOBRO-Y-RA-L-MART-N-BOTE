<?php
require_once "autoload.php";
session_start();
ob_start();


use Dwes\ProyectoVideoclub\Soporte;
use Dwes\ProyectoVideoclub\Cliente;

// Comprobar la sesión
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin' || !isset($_SESSION['clientes']) || !isset($_SESSION['soportes'])) {
    // Si no es admin o faltan datos, redirigir al login
    $_SESSION['error_login'] = 'Acceso no autorizado. Debe iniciar sesión como Administrador.';
    header('Location: index.php');
    ob_end_flush();
    exit;
}

$userName = $_SESSION['user_name'];
$clientes = $_SESSION['clientes']; // Array de objetos Cliente
$soportes = $_SESSION['soportes']; // Array de objetos Soporte

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Videoclub - Panel de Administración</title>
</head>

<body>
    <div class="container">
        <a href="logout.php" class="logout">Cerrar Sesión</a>
        <h1>Videoclub - Panel de Administración</h1>

        <div class="welcome">
            Bienvenido, <strong><?php echo htmlspecialchars($userName); ?></strong>
            <input type="button" value="+ Nuevo Cliente"
                onclick="window.location.href='formCreateCliente.php'"
                style="margin-left: 15px; padding: 8px 16px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
        </div>

        <h2>Listado de Clientes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nº Cliente</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Alquileres Activos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): /* @var $cliente Cliente */ ?>
                    <tr>
                        <td>
                            <?php echo $cliente->getNumero(); ?>
                            <a href="formUpdateCliente.php?numero=<?= $cliente->getNumero() ?>"
                                style="margin-left: 8px; color: #007bff; font-size: 0.9em;">[Editar]</a>
                        </td>
                        <td><?php echo htmlspecialchars($cliente->getNombre()); ?></td>
                        <td><?php echo htmlspecialchars($cliente->getUser()); ?></td>
                        <td><?php echo $cliente->getNumSoporteAlquilado(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Listado de Soportes</h2>
        <div>
            <?php foreach ($soportes as $soporte): /* @var $soporte Soporte */ ?>
                <div class="soporte-info">
                    <?php
                    // Uso de muestraResumen() para mostrar detalles
                    $soporte->muestraResumen();
                    echo " | Precio (IVA incl.): " . number_format($soporte->getPrecioConIva(), 2) . " €";
                    echo " | Estado: " . ($soporte->alquilado ? 'Alquilado' : 'Disponible');
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>
<?php ob_end_flush(); ?>