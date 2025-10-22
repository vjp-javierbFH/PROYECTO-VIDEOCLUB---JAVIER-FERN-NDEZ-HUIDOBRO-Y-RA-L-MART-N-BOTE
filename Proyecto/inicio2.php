<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio2</title>
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
        require_once "autoload.php";
        use Dwes\ProyectoVideoclub\CintaVideo;
        use Dwes\ProyectoVideoclub\Dvd;
        use Dwes\ProyectoVideoclub\Juego;
        use Dwes\ProyectoVideoclub\Cliente;
        use Dwes\ProyectoVideoclub\Soporte;
        echo "<h1>Videoclub</h1>";
        echo "<h2>Inicio2</h2>";
        echo "<h3>Prueba Cliente</h3>";
        //instanciamos un par de objetos cliente
        $cliente1 = new Cliente("Bruce Wayne", 23);
        $cliente2 = new Cliente("Clark Kent", 33);
        echo "Identificando clientes.";
        //mostramos el número de cada cliente creado
        echo "<br>El identificador del cliente 1 es: <strong>" . $cliente1->getNumero() . "</strong>";
        echo "<br>El identificador del cliente 2 es: <strong>" . $cliente2->getNumero() . "</strong><br>";
        //instancio algunos soportes
        $soporte1 = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
        $soporte2 = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
        $soporte3 = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
        $soporte4 = new Dvd("El Imperio Contraataca", 4, 3, "es,en", "16:9");
        echo "<br>Cliente <strong>" . $cliente1->getNumero() . "</strong> alquilando...<br>";
        //alquilo algunos soportes
        $cliente1->alquilar($soporte1)
            ->alquilar($soporte2)
            ->alquilar($soporte3);
        //voy a intentar alquilar de nuevo un soporte que ya tiene alquilado
        $cliente1->alquilar($soporte1);
        //el cliente tiene 3 soportes en alquiler como máximo
        //este soporte no lo va a poder alquilar
        $cliente1->alquilar($soporte4);
        //este soporte no lo tiene alquilado
        $cliente1->devolver(4);
        //devuelvo un soporte que sí que tiene alquilado
        $cliente1->devolver(2);
        //alquilo otro soporte
        $cliente1->alquilar($soporte4);
        echo "<br>";
        //listo los elementos alquilados
        echo "Lista de alquileres del cliente <strong>" . $cliente1->getNumero() . "</strong><br>";
        $cliente1->listarAlquileres();
        //este cliente no tiene alquileres
        echo "<br>Cliente <strong>" . $cliente2->getNumero() . "</strong> devolviendo soporte...<br>";
        $cliente2->devolver(2);
        ?>
    </div>
</body>

</html>