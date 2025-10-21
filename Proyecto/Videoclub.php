<?php
require_once "Cliente.php";
require_once "CintaVideo.php";
require_once "Dvd.php";
require_once "Juego.php";


class Videoclub
{
    // Atributos
    private string $nombre;
    private array $productos = [];
    private int $numProductos = 0;
    private array $socios = [];
    private int $numSocios = 0;

    // Constructor
    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
    }

    // Método para incluir producto
    private function incluirProducto(Soporte $s): void
    {
        $this->productos[] = $s;
        $this->numProductos++;
    }

    // Método para incluir conta de videos
    public function incluirCintaVideo(string $titulo, float $precio, int $duracion): CintaVideo
    {
        $numero = $this->numProductos + 1; // asignamos número automático
        $cinta = new CintaVideo($titulo, $numero, $precio, $duracion);
        $this->incluirProducto($cinta);
        return $cinta;
    }

    // Método para incluir dvd
    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): Dvd
    {
        $numero = $this->numProductos + 1;
        $dvd = new Dvd($titulo, $numero, $precio, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
        return $dvd;
    }

    // Método para incluir juegos
    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): Juego
    {
        $numero = $this->numProductos + 1;
        $juego = new Juego($titulo, $numero, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
        return $juego;
    }

    // Método para incluir socios
    public function incluirSocio(string $nombre, int $maxAlquileresConcurrentes = 3): Cliente
    {
        $numero = $this->numSocios + 1;
        $cliente = new Cliente($nombre, $numero, $maxAlquileresConcurrentes);
        $this->socios[] = $cliente;
        $this->numSocios++;
        return $cliente;
    }

    // Método para listar productos
    public function listarProductos(): void
    {
        echo "<h3>Productos del Videoclub " . $this->nombre . ":</h3>";
        if (empty($this->productos)) {
            echo "No hay productos.<br>";
        } else {
            foreach ($this->productos as $p) {
                // Usamos el método del interfaz Resumible
                if ($p instanceof Resumible) {
                    $p->muestraResumen();
                }
            }
        }
    }

    // --- LISTAR SOCIOS ---
    public function listarSocios(): void
    {
        echo "<h3>Socios del Videoclub " . $this->nombre . ":</h3>";
        if (empty($this->socios)) {
            echo "No hay socios.<br>";
        } else {
            foreach ($this->socios as $s) {
                $s->mostrarCliente();
                echo "<br>";
            }
        }
    }

    // Método para alquilar un producto a un socio
    public function alquilarSocioProducto(int $numCliente, int $numeroSoporte): void
    {
        // Buscar cliente
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numCliente) {
                $cliente = $s;
                break;
            }
        }
        if (!$cliente) {
            echo "No se encontró el socio con número $numCliente.<br>";
            return;
        }

        // Buscar soporte
        $producto = null;
        foreach ($this->productos as $p) {
            if ($p->getNumero() === $numeroSoporte) {
                $producto = $p;
                break;
            }
        }
        if (!$producto) {
            echo "No se encontró el producto con número $numeroSoporte.<br>";
            return;
        }

        // Intentar alquilar
        $cliente->alquilar($producto);
    }
}
