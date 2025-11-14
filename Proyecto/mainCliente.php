<?php
require_once "autoload.php";
session_start();
ob_start();


use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Soporte;

// Comprobar la sesión
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'cliente' || !isset($_SESSION['cliente_data'])) {
    // Si no es un cliente válido, redirigir al login
    $_SESSION['error_login'] = 'Acceso no autorizado. Debe iniciar sesión como Cliente.';
    header('Location: index.php');
    ob_end_flush();
    exit;
}

$userName = $_SESSION['user_name'];
// Recuperar y deserializar el objeto Cliente. Esto es crucial para acceder a sus métodos y propiedades.
$cliente = unserialize($_SESSION['cliente_data']); /* @var $cliente Cliente */

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Videoclub - Panel de Cliente</title>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout">Cerrar Sesión</a>
        <h1>Videoclub - Panel de Cliente</h1>
        
        <div class="welcome">
            Bienvenido, <strong><?php echo htmlspecialchars($userName); ?></strong>. Tienes <?php echo $cliente->getNumSoporteAlquilado(); ?> alquiler(es) activo(s).
        </div>

        <h2>Mis Alquileres Actuales</h2>
        
        <div class="alquileres-list">
            <?php 
            // Llamamos al nuevo método getAlquileres()
            $alquileres = $cliente->getAlquileres();
            
            if (empty($alquileres)) {
                echo "<p class='no-alquileres'>Actualmente no tienes ningún soporte alquilado.</p>";
            } else {
                foreach ($alquileres as $soporte): /* @var $soporte Soporte */ ?>
                    <div class="alquiler-item">
                        <?php 
                            // Uso de muestraResumen() para mostrar detalles
                            $soporte->muestraResumen();
                            echo " | Precio (IVA incl.): " . number_format($soporte->getPrecioConIva(), 2) . " €";
                        ?>
                    </div>
                <?php endforeach; 
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>