<?php
require_once "autoload.php";
session_start();
ob_start();

use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Cliente;

$user = trim($_POST['user'] ?? '');
$password = $_POST['password'] ?? '';
$error = 'Acceso incorrecto. Por favor, verifica tu usuario y contraseña.';

// === FUNCIÓN: Inicializar datos de prueba ===
function inicializarDatos()
{
    // --- SOPORTES ---
    $soportes = [
        new Juego("God of War", 1, 19.99, "PS4", 1, 1),
        new Juego("The Last of Us Part II", 2, 49.99, "PS4", 1, 1),
        new Dvd("Torrente", 3, 4.5, "es", "16:9"),
        new Dvd("Origen", 4, 15, "es,en,fr", "16:9"),
        new Dvd("El Imperio Contraataca", 5, 3, "es,en", "16:9"),
        new CintaVideo("Los cazafantasmas", 6, 3.5, 107),
        new CintaVideo("El nombre de la Rosa", 7, 1.5, 140),
    ];

    // --- CLIENTES con password_hash() ---
    $cliente1 = new Cliente("Bruce Wayne", 101, "bruce", password_hash("batman", PASSWORD_DEFAULT));
    $cliente2 = new Cliente("Clark Kent", 102, "clark", password_hash("superman", PASSWORD_DEFAULT));
    $cliente3 = new Cliente("Usuario Generico", 103, "usuario", password_hash("usuario", PASSWORD_DEFAULT));

    // --- ALQUILERES DE PRUEBA ---
    try {
        $cliente1->alquilar($soportes[0]); // God of War
        $cliente1->alquilar($soportes[2]); // Torrente
    } catch (\Throwable $e) {
    }

    try {
        $cliente3->alquilar($soportes[4]); // El Imperio
    } catch (\Throwable $e) {
    }

    $clientes = [$cliente1, $cliente2, $cliente3];

    return ['soportes' => $soportes, 'clientes' => $clientes];
}

// === 1. LOGIN ADMIN ===
if ($user === 'admin' && $password === 'admin') {
    $_SESSION['user_name'] = 'Administrador';
    $_SESSION['role'] = 'admin';

    $datos = inicializarDatos();
    $_SESSION['soportes'] = $datos['soportes'];
    $_SESSION['clientes'] = $datos['clientes'];

    header('Location: mainAdmin.php');
    ob_end_flush();
    exit;
}

// === 2. LOGIN CLIENTE ===
$datos = inicializarDatos();
$cliente_encontrado = null;

foreach ($datos['clientes'] as $cliente) {
    if (
        strcasecmp($cliente->getUser(), $user) === 0 &&
        password_verify($password, $cliente->getPassword())
    ) {
        $cliente_encontrado = $cliente;
        break;
    }
}

if ($cliente_encontrado) {
    $_SESSION['user_name'] = $cliente_encontrado->getUser(); // ← "bruce", "usuario", etc.
    $_SESSION['role'] = 'cliente';
    $_SESSION['cliente_data'] = serialize($cliente_encontrado);

    // Cargar soportes también para el cliente
    $_SESSION['soportes'] = $datos['soportes'];

    header('Location: mainCliente.php');
    ob_end_flush();
    exit;
}

// === 3. ERROR ===
$_SESSION['error_login'] = $error;
header('Location: index.php');
ob_end_flush();
exit;
