<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\Cliente;

// === 1. SEGURIDAD: Comprobar sesión y POST ===
if (!isset($_SESSION['user_name']) || !isset($_POST['numero'])) {
    header('Location: index.php');
    exit;
}

$numeroCliente = (int)$_POST['numero'];
$cliente = null;

// === 2. Buscar cliente en sesión global ===
foreach ($_SESSION['clientes'] as $c) {
    if ($c->getNumero() === $numeroCliente) {
        $cliente = $c;
        break;
    }
}

if (!$cliente) {
    $_SESSION['error_cliente'] = 'Cliente no encontrado.';
    header('Location: mainAdmin.php');
    exit;
}

// === 3. Verificar permisos ===
$esAdmin = ($_SESSION['role'] ?? '') === 'admin';
$esPropietario = strcasecmp(
    ($_SESSION['user_name'] ?? ''),
    $cliente->getUser()
) === 0;

if (!$esAdmin && !$esPropietario) {
    $_SESSION['error_login'] = 'No tienes permiso para editar este cliente.';
    header('Location: index.php');
    exit;
}

// === 4. Recoger y validar datos ===
$nombre = trim($_POST['nombre'] ?? '');
$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';
$maxAlquileres = (int)($_POST['maxAlquileres'] ?? 3);

$errores = [];

if (empty($nombre)) $errores[] = 'El nombre es obligatorio.';
if (empty($usuario)) $errores[] = 'El usuario es obligatorio.';
if ($maxAlquileres < 1 || $maxAlquileres > 10) $errores[] = 'Máx. alquileres: 1-10.';

// Comprobar si el usuario ya existe (excepto él mismo)
foreach ($_SESSION['clientes'] as $c) {
    if ($c->getNumero() !== $numeroCliente && strcasecmp($c->getUser(), $usuario) === 0) {
        $errores[] = 'El usuario ya está en uso por otro cliente.';
    }
}

if ($errores) {
    $_SESSION['error_cliente'] = implode('<br>', $errores);
    header("Location: formUpdateCliente.php?numero=$numeroCliente");
    exit;
}

// === 5. ACTUALIZAR CLIENTE CON SETTERS ===
$cliente->setNombre($nombre);
$cliente->setUser($usuario);
$cliente->setMaxAlquilerConcurrente($maxAlquileres);

if (!empty($password)) {
    $cliente->setPassword(password_hash($password, PASSWORD_DEFAULT));
}

// === 6. Guardar en sesión global ===
foreach ($_SESSION['clientes'] as $i => $c) {
    if ($c->getNumero() === $numeroCliente) {
        $_SESSION['clientes'][$i] = $cliente;
        break;
    }
}

// === 7. Si es el cliente logueado, actualizar cliente_data ===
if ($esPropietario && isset($_SESSION['cliente_data'])) {
    $_SESSION['cliente_data'] = serialize($cliente);
    $_SESSION['user_name'] = $cliente->getUser(); // Actualiza el login
}

// === 8. Mensaje de éxito y redirección ===
$_SESSION['exito_cliente'] = "Perfil actualizado correctamente.";

$redirect = $esAdmin ? 'mainAdmin.php' : 'mainCliente.php';
header("Location: $redirect");
exit;