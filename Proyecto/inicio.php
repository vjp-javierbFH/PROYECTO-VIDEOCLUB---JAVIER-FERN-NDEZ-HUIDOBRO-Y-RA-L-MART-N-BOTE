<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        body{
            background-color: rgb(236, 205, 207);
        }
        .estilo{
            color: rgb(0, 0, 0);
        }
        .estilo h1 {
            color: rgb(216, 63, 63);
        }
        .estilo h3{
            color: rgb(95, 41, 41);
        }
        .estilo strong {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        .estilo p {
            color: red;
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
    </style>
</head>

<body>
    <div class="estilo">
        <?php
        echo "<h1>Videoclub</h1><h2>Inicio</h2>";
        // Pruebas de ejecución
        echo "<h3>Prueba Soporte.php</h3>";
        // Inicializo utilizando constructor por parámetro
        echo ("<p>Cuando la clase Soporte es abstracta no permite la instanciación, por lo que no puedo utilizar el constructor por parámetro.<p>");
        // include "Soporte.php";
        // $soporte1 = new Soporte("Tenet", 22, 3);
        // echo "<strong>" . $soporte1->getTitulo() . "</strong>";
        // echo "<br>Precio: " . $soporte1->getPrecio() . " euros";
        // echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
        // $soporte1->muestraResumen();
        require_once "autoload.php";
        use Dwes\ProyectoVideoclub\CintaVideo;
        use Dwes\ProyectoVideoclub\Dvd;
        use Dwes\ProyectoVideoclub\Juego;
        use Dwes\ProyectoVideoclub\Cliente;
        use Dwes\ProyectoVideoclub\Soporte;
        echo "<h3>Prueba CintaVideo.php</h3>";
        $miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
        echo "<strong>" . $miCinta->getTitulo() . "</strong>";
        echo "<br>Precio: " . $miCinta->getPrecio() . " euros";
        echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
        $miCinta->muestraResumen();
        echo "<h3>Prueba Dvd.php</h3>";
        $miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
        echo "<strong>" . $miDvd->getTitulo() . "</strong>";
        echo "<br>Precio: " . $miDvd->getPrecio() . " euros";
        echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
        $miDvd->mostrarResumen();
        echo "<h3>Prueba Juego.php</h3>";
        $miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
        echo "<strong>" . $miJuego->getTitulo() . "</strong>";
        echo "<br>Precio: " . $miJuego->getPrecio() . " euros";
        echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
        $miJuego->muestraResumen();
        ?>
    </div>
</body>

</html>