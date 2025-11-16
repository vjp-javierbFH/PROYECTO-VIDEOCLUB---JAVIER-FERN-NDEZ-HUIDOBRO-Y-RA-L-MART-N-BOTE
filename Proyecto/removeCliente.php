<?php
require_once "autoload.php";
session_start();
ob_start();

// === SEGURIDAD: Solo admin ===
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin' || !isset($_POST['numero'])) {
    $_SESSION['error_cliente'] = 'Acceso no autorizado.';
    header('Location: index.php');
    exit;
}

$numeroCliente = (int)$_POST['numero'];
$eliminado = false;

// === Buscar y eliminar cliente ===
foreach ($_SESSION['clientes'] as $i => $cliente) {
    if ($cliente->getNumero() === $numeroCliente) {
        // Opcional: comprobar si tiene alquileres activos
        if ($cliente->getNumSoporteAlquilado() > 0) {
            $_SESSION['error_cliente'] = "No se puede eliminar al cliente '{$cliente->getNombre()}' porque tiene alquileres activos.";
            header('Location: mainAdmin.php');
            exit;
        }

        unset($_SESSION['clientes'][$i]);
        $eliminado = true;
        break;
    }
}

if ($eliminado) {
    // Reindexar array (opcional, pero recomendado)
    $_SESSION['clientes'] = array_values($_SESSION['clientes']);

    $_SESSION['exito_cliente'] = "Cliente eliminado correctamente.";
} else {
    $_SESSION['error_cliente'] = "Cliente no encontrado.";
}

header('Location: mainAdmin.php');
exit;
