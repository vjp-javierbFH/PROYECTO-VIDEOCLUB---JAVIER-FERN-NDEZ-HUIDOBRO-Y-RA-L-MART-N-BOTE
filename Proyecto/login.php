<?php
require_once "autoload.php";
session_start();
ob_start(); // Iniciar buffer de salida



use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Cliente;

$user = $_POST['user'] ?? '';
$password = $_POST['password'] ?? '';
$error = 'Acceso incorrecto. Por favor, verifica tu usuario y contraseña.';

// Función para inicializar los datos de prueba
function inicializarDatos()
{
    // --- 1. Soportes de Prueba ---
    // Usamos IDs fijos para los soportes para simular IDs de BD
    $soportes = [
        new Juego("God of War", 1, 19.99, "PS4", 1, 1),
        new Juego("The Last of Us Part II", 2, 49.99, "PS4", 1, 1),
        new Dvd("Torrente", 3, 4.5, "es", "16:9"),
        new Dvd("Origen", 4, 15, "es,en,fr", "16:9"),
        new Dvd("El Imperio Contraataca", 5, 3, "es,en", "16:9"),
        new CintaVideo("Los cazafantasmas", 6, 3.5, 107),
        new CintaVideo("El nombre de la Rosa", 7, 1.5, 140),
    ];

    // --- 2. Clientes de Prueba ---
    // Usamos el constructor modificado: __construct(String $nombre, int $numero, string $user, string $password)
    $cliente1 = new Cliente("Bruce Wayne", 101, "bruce", "batman");
    // Cliente para 'usuario/usuario'
    $cliente2 = new Cliente("Clark Kent", 102, "clark", "superman");
    $cliente3 = new Cliente("Usuario Generico", 103, "usuario", "usuario"); 

    // Alquileres de prueba para Cliente1 (Bruce)
    // Nota: Al alquilar, el objeto Soporte se marca como alquilado.
    try {
        $cliente1->alquilar($soportes[0]); // God of War (ID: 1)
        $cliente1->alquilar($soportes[2]); // Torrente (ID: 3)
    } catch (\Throwable $e) { /* Manejo de excepciones en el contexto de inicialización */ }
    
    // Alquileres de prueba para Cliente3 (usuario)
    try {
        $cliente3->alquilar($soportes[4]); // El Imperio Contraataca (ID: 5)
    } catch (\Throwable $e) { /* Manejo de excepciones en el contexto de inicialización */ }

    $clientes = [
        $cliente1,
        $cliente2,
        $cliente3,
    ];

    return ['soportes' => $soportes, 'clientes' => $clientes];
}

// 1. Verificar credenciales de Administrador
if ($user === 'admin' && $password === 'admin') {
    $_SESSION['user_name'] = 'Administrador';
    $_SESSION['role'] = 'admin';
    
    // Cargar datos de soportes y clientes en la sesión
    $datos = inicializarDatos();
    $_SESSION['soportes'] = $datos['soportes'];
    $_SESSION['clientes'] = $datos['clientes'];
    
    header('Location: mainAdmin.php');
    ob_end_flush();
    exit;
}

// 2. Verificar credenciales de Cliente (coincidencia con clientes cargados)
$datos = inicializarDatos();
$clientes_disponibles = $datos['clientes'];
$cliente_encontrado = null;

foreach ($clientes_disponibles as $cliente) {
    if ($cliente->getUser() === $user && $cliente->getPassword() === $password) {
        $cliente_encontrado = $cliente;
        break;
    }
}

if ($cliente_encontrado) {
    $_SESSION['user_name'] = $cliente_encontrado->getNombre();
    $_SESSION['role'] = 'cliente';
    
    // Almacenar el objeto cliente serializado para preservar sus datos (incluidos los alquileres)
    $_SESSION['cliente_data'] = serialize($cliente_encontrado);
    
    header('Location: mainCliente.php');
    ob_end_flush();
    exit;
}

// 3. Credenciales incorrectas
$_SESSION['error_login'] = $error;
header('Location: index.php');
ob_end_flush();
exit;