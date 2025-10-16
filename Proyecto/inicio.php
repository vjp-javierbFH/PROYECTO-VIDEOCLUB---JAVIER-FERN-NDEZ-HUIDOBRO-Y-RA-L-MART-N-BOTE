<?php
// Pruebas de ejecución
include "Soporte.php";
echo "<h2>Prueba Soporte.php</h2>";
// Inicializo utilizando constructor por parámetro
$soporte1 = new Soporte("Tenet", 22, 3);
echo "<strong>" . $soporte1->getTitulo() . "</strong>";
echo "<br>Precio: " . $soporte1->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->mostrarSoporte();

include "CintaVideo.php";
echo "<h2>Prueba CintaVideo.php</h2>";
$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
echo "<strong>" . $miCinta->getTitulo() . "</strong>";
echo "<br>Precio: " . $miCinta->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
$miCinta->mostrarCintaVideo();
