<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\Cliente;

// === SEGURIDAD ===
if (!isset($_SESSION['user_name']) || !isset($_POST['numero'])) {
    header('Location: index.php');
    exit;
}

$numeroCliente = (int)$_POST['numero'];
$cliente = null;

// Buscar cliente
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

$esAdmin = ($_SESSION['role'] ?? '') === 'admin';
$esPropietario = ($_SESSION['user_name'] ?? '') === $cliente->getUser();

if (!$esAdmin && !$esPropietario) {
    $_SESSION['error_login'] = 'No tienes permiso.';
    header('Location: index.php');
    exit;
}

// === RECOGER DATOS ===
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
    if ($c->getNumero() !== $numeroCliente && $c->getUser() === $usuario) {
        $errores[] = 'El usuario ya está en uso por otro cliente.';
    }
}

if ($errores) {
    $_SESSION['error_cliente'] = implode('<br>', $errores);
    header("Location: formUpdateCliente.php?numero=$numeroCliente");
    exit;
}

// === ACTUALIZAR CLIENTE ===
$cliente->nombre = $nombre;
$cliente->user = $usuario;
$cliente->maxAlquilerConcurrente = $maxAlquileres;

if (!empty($password)) {
    $cliente->password = password_hash($password, PASSWORD_DEFAULT);
}

// === GUARDAR EN SESIÓN ===
$_SESSION['clientes'] = array_map(function($c) use ($cliente, $numeroCliente) {
    return $c->getNumero() === $numeroCliente ? $cliente : $c;
}, $_SESSION['clientes']);

$_SESSION['exito_cliente'] = "Cliente actualizado correctamente.";

// === REDIRIGIR ===
$redirect = $esAdmin ? 'mainAdmin.php' : 'mainCliente.php';
header("Location: $redirect");
exit;