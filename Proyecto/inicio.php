<?php
echo "<h1>Videoclub</h1><h2>Javier</h2>";
// Pruebas de ejecución
echo "<h3>Prueba Soporte.php</h3>";
// Inicializo utilizando constructor por parámetro
$soporte1 = new Soporte("Tenet", 22, 3);
echo "<strong>" . $soporte1->getTitulo() . "</strong>";
echo "<br>Precio: " . $soporte1->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->mostrarSoporte();

include "CintaVideo.php";
echo "<h3>Prueba CintaVideo.php</h3>";
$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
echo "<strong>" . $miCinta->getTitulo() . "</strong>";
echo "<br>Precio: " . $miCinta->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
$miCinta->mostrarCintaVideo();


include "Dvd.php";
echo "<h3>Prueba Dvd.php</h3>"
$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9"); 
echo "<strong>" . $miDvd->titulo . "</strong>"; 
echo "<br>Precio: " . $miDvd->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
$miDvd->mostrarDvd();
