<?php
spl_autoload_register(function ($clase) {
    // Espacio de nombres prefijo
    $prefijo = 'Dwes\\ProyectoVideoclub\\';

    // Directorio base donde se encuentran las clases
    $directiorioBase = __DIR__ . '/app/Dwes/ProyectoVideoclub/';

    // Comprobar si la clase utiliza el prefijo del namespace
    $len = strlen($prefijo);
    if (strncmp($prefijo, $clase, $len) !== 0) {
        // No es una clase del espacio de nombres, salir del autoloader
        return;
    }

    // Obtener el nombre relativo de la clase
    $nombre_relativo = substr($clase, $len);

    // Reemplazar los separadores de namespace por separadores de directorio y añadir la extensión .php
    $fichero = $directiorioBase . str_replace('\\', '/', $nombre_relativo) . '.php';

    // Si el fichero existe, incluirlo
    if (file_exists($fichero)) {
        require $fichero;
    }
});