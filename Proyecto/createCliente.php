<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\Cliente;

// === 1. Seguridad: solo admin ===
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// === 2. Recoger y validar datos ===
$nombre = trim($_POST['nombre'] ?? '');
$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';
$maxAlquileres = (int)($_POST['maxAlquileres'] ?? 3);

$errores = [];

if (empty($nombre)) $errores[] = 'El nombre es obligatorio.';
if (empty($usuario)) $errores[] = 'El usuario es obligatorio.';
if (empty($password)) $errores[] = 'La contraseña es obligatoria.';
if ($maxAlquileres < 1 || $maxAlquileres > 10) $errores[] = 'Máx. alquileres: 1-10.';

if ($errores) {
    $_SESSION['error_cliente'] = implode('<br>', $errores);
    $_SESSION['old_nombre'] = $nombre;
    $_SESSION['old_usuario'] = $usuario;
    header('Location: formCreateCliente.php');
    exit;
}

// === 3. Comprobar si el usuario ya existe ===
if (isset($_SESSION['clientes'])) {
    foreach ($_SESSION['clientes'] as $cliente) {
        if ($cliente->getUser() === $usuario) {
            $_SESSION['error_cliente'] = 'El usuario ya existe.';
            $_SESSION['old_nombre'] = $nombre;
            header('Location: formCreateCliente.php');
            exit;
        }
    }
}

// === 4. Crear cliente ===
$nuevoNumero = (isset($_SESSION['clientes']) ? count($_SESSION['clientes']) : 0) + 1;

$nuevoCliente = new Cliente(
    $nombre,
    $nuevoNumero,
    $usuario,
    password_hash($password, PASSWORD_DEFAULT),
    $maxAlquileres
);

// === 5. Guardar en sesión ===
$_SESSION['clientes'][] = $nuevoCliente;

// === 6. Limpieza y redirección ===
unset($_SESSION['old_nombre'], $_SESSION['old_usuario'], $_SESSION['error_cliente']);

// ¡REDIRECCIÓN CORRECTA!
header('Location: mainAdmin.php');
exit;