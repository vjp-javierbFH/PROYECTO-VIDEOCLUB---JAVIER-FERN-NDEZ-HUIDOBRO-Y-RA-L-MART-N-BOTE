<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\Soporte;
use Dwes\ProyectoVideoclub\Cliente;

// === SEGURIDAD: Solo admin ===
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin' || !isset($_SESSION['clientes']) || !isset($_SESSION['soportes'])) {
    $_SESSION['error_login'] = 'Acceso no autorizado. Debe iniciar sesión como Administrador.';
    header('Location: index.php');
    ob_end_flush();
    exit;
}

$userName = $_SESSION['user_name'];
$clientes = $_SESSION['clientes'];
$soportes = $_SESSION['soportes'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub - Panel de Administración</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; color: #333; line-height: 1.6; }
        .container { max-width: 1100px; margin: 2rem auto; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .logout { float: right; color: #dc3545; text-decoration: none; font-weight: 600; font-size: 0.9em; }
        .logout:hover { text-decoration: underline; }
        h1 { color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 12px; margin-bottom: 20px; font-size: 1.8em; }
        .welcome { background: #e8f4fc; padding: 16px; border-radius: 8px; margin-bottom: 25px; font-size: 1.1em; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; }
        .btn-nuevo {
            background: #28a745; color: white; padding: 10px 18px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; text-decoration: none; font-size: 14px; transition: background 0.3s;
        }
        .btn-nuevo:hover { background: #218838; }
        h2 { color: #2c3e50; margin: 25px 0 15px; font-size: 1.5em; border-left: 5px solid #3498db; padding-left: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 0.95em; }
        th, td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: 600; color: #495057; }
        tr:hover { background: #f1f3f5; }
        .acciones { white-space: nowrap; }
        .btn-edit { color: #007bff; text-decoration: none; margin-right: 10px; font-weight: 500; }
        .btn-edit:hover { text-decoration: underline; }
        .btn-delete {
            background: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.85em; font-weight: bold;
        }
        .btn-delete:hover { background: #c82333; }
        .soporte-info {
            background: #f8f9fa; padding: 14px; margin: 10px 0; border-radius: 8px; border-left: 4px solid #17a2b8; font-size: 0.95em;
        }
        .estado-alquilado { color: #e74c3c; font-weight: bold; }
        .estado-disponible { color: #27ae60; font-weight: bold; }
        .mensaje { padding: 12px; border-radius: 6px; margin: 15px 0; font-weight: bold; }
        .exito { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        @media (max-width: 768px) {
            .welcome { flex-direction: column; text-align: center; }
            .btn-nuevo { margin-top: 10px; }
            table, thead, tbody, th, td, tr { display: block; }
            thead tr { position: absolute; top: -9999px; left: -9999px; }
            tr { border: 1px solid #ccc; margin-bottom: 10px; border-radius: 8px; overflow: hidden; }
            td { border: none; position: relative; padding-left: 50%; }
            td:before { content: attr(data-label); position: absolute; left: 12px; width: 45%; font-weight: bold; color: #555; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout">Cerrar Sesión</a>
        <h1>Videoclub - Panel de Administración</h1>

        <!-- MENSAJES -->
        <?php if (isset($_SESSION['exito_cliente'])): ?>
            <div class="mensaje exito">
                <?= htmlspecialchars($_SESSION['exito_cliente']) ?>
                <?php unset($_SESSION['exito_cliente']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_cliente'])): ?>
            <div class="mensaje error">
                <?= htmlspecialchars($_SESSION['error_cliente']) ?>
                <?php unset($_SESSION['error_cliente']); ?>
            </div>
        <?php endif; ?>

        <!-- BIENVENIDA + NUEVO CLIENTE -->
        <div class="welcome">
            <span>Bienvenido, <strong><?= htmlspecialchars($userName) ?></strong></span>
            <a href="formCreateCliente.php" class="btn-nuevo">+ Nuevo Cliente</a>
        </div>

        <!-- LISTADO DE CLIENTES -->
        <h2>Listado de Clientes (<?= count($clientes) ?>)</h2>
        <?php if (empty($clientes)): ?>
            <p style="color: #6c757d; font-style: italic;">No hay clientes registrados.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nº Cliente</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Alquileres Activos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td class="acciones" data-label="Acciones">
                                <a href="formUpdateCliente.php?numero=<?= $cliente->getNumero() ?>" class="btn-edit">Editar</a>
                                <form action="removeCliente.php" method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Estás seguro de eliminar al cliente \"<?= htmlspecialchars($cliente->getNombre()) ?>\" (<?= htmlspecialchars($cliente->getUser()) ?>)?\n\nEsta acción no se puede deshacer.');">
                                    <input type="hidden" name="numero" value="<?= $cliente->getNumero() ?>">
                                    <button type="submit" class="btn-delete">Eliminar</button>
                                </form>
                            </td>
                            <td data-label="Nº Cliente"><?= $cliente->getNumero() ?></td>
                            <td data-label="Nombre"><?= htmlspecialchars($cliente->getNombre()) ?></td>
                            <td data-label="Usuario"><?= htmlspecialchars($cliente->getUser()) ?></td>
                            <td data-label="Alquileres">
                                <strong><?= $cliente->getNumSoporteAlquilado() ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- LISTADO DE SOPORTES -->
        <h2>Listado de Soportes (<?= count($soportes) ?>)</h2>
        <?php if (empty($soportes)): ?>
            <p style="color: #6c757d; font-style: italic;">No hay soportes registrados.</p>
        <?php else: ?>
            <div>
                <?php foreach ($soportes as $soporte): ?>
                    <div class="soporte-info">
                        <?php 
                        $soporte->muestraResumen();
                        echo " | <strong>Precio (IVA incl.): " . number_format($soporte->getPrecioConIva(), 2) . " €</strong>";
                        echo " | Estado: <span class='" . ($soporte->alquilado ? 'estado-alquilado' : 'estado-disponible') . "'>";
                        echo $soporte->alquilado ? 'Alquilado' : 'Disponible';
                        echo "</span>";
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>