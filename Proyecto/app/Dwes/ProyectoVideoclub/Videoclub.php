<?php

namespace Dwes\ProyectoVideoclub;

require_once "Cliente.php";
require_once "CintaVideo.php";
require_once "Dvd.php";
require_once "Juego.php";

use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\ClienteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\VideoclubException;


class Videoclub
{
    // Atributos
    private string $nombre;
    private array $productos = [];
    private int $numProductos = 0;
    private array $socios = [];
    private int $numSocios = 0;

    private int $numProductosAlquilados = 0;
    private int $numTotalAlquileres = 0;

    // Constructor
    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
        $this->productos = [];
        $this->socios = [];
        $this->numProductos = 0;
        $this->numSocios = 0;
        $this->numProductosAlquilados = 0;
        $this->numTotalAlquileres = 0;
    }
    public function getNumProductosAlquilados(): int
    {
        return $this->numProductosAlquilados;
    }
    public function getNumTotalAlquileres(): int
    {
        return $this->numTotalAlquileres;
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

    // Método privado para buscar soporte por número
    private function buscarSoporte(int $numeroSoporte): ?Soporte
    {
        foreach ($this->productos as $p) {
            if ($p->getNumero() === $numeroSoporte) {
                return $p;
            }
        }
        return null;
    }

    // Método para alquilar un producto a un socio
    public function alquilarSocioProducto(int $numCliente, array $numerosProductos): Videoclub
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
            return $this;
        }
        // Verificar todos los productos antes de alquilar
        $soportesAlquilables = [];
        foreach ($numerosProductos as $numSoporte) {
            $producto = $this->buscarSoporte($numSoporte);
            if (!$producto) {
                echo "ERROR: Producto con número $numSoporte no encontrado.<br>";
                return $this;
            }
            if ($producto->alquilado) {
                echo "ERROR: Producto " . $producto->getTitulo() . " ya está alquilado. Ningún producto alquilado.<br>";
                return $this;
            }
            if ($cliente->tieneAlquilado($producto)) {
                echo "ERROR: Cliente ya tiene alquilado " . $producto->getTitulo() . ". Ningún producto alquilado.<br>";
                return $this;
            }
            $soportesAlquilables[] = $producto;
        }

        // Intentar alquilar
        try {
            foreach ($soportesAlquilables as $producto) {
                // El método alquilar de Cliente gestiona la excepción SoporteYaAlquiladoException y CupoSuperadoException
                $cliente->alquilar($producto);
                $this->numProductosAlquilados++;
                $this->numTotalAlquileres++;
            }
            echo "Alquiler de múltiples productos realizado con éxito para el cliente " . $cliente->getNumero() . ".<br>";
        } catch (CupoSuperadoException $e) {
            // Si el cupo se supera en medio del proceso, revertir
            echo "<strong>ERROR:</strong> " . $e->getMessage() . " Se revertirán los alquileres de este intento.<br>";

            // Lógica de reversión simple: devolver los que se hayan alquilado en esta llamada
            foreach ($soportesAlquilables as $producto) {
                if ($cliente->tieneAlquilado($producto)) {
                    $cliente->devolver($producto->getNumero());
                    // Revertir contadores
                    $this->numProductosAlquilados--;
                }
            }
        } catch (SoporteYaAlquiladoException $e) {
            // Esta excepción no debería ocurrir si el chequeo inicial es correcto, pero se captura para seguridad
            echo "<strong>ERROR:</strong> " . $e->getMessage() . "<br>";
        }

        return $this;
    }
    public function devolverSocioProducto(int $numSocio, int $numeroProducto): Videoclub
    {
        // Buscar cliente
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numSocio) {
                $cliente = $s;
                break;
            }
        }
        if (!$cliente) {
            echo "No se encontró el socio con número $numSocio.<br>";
            return $this;
        }

        try {
            $cliente->devolver($numeroProducto);
            // Si la devolución es exitosa, se decrementa el contador
            $this->numProductosAlquilados--;
        } catch (SoporteNoEncontradoException $e) {
            echo "<strong>ERROR:</strong> " . $e->getMessage() . "<br>";
        }

        return $this;
    }

    // Devolver múltiples productos por un socio
    public function devolverSocioProductos(int $numSocio, array $numerosProductos): Videoclub
    {
        // Buscar cliente
        $cliente = null;
        foreach ($this->socios as $s) {
            if ($s->getNumero() === $numSocio) {
                $cliente = $s;
                break;
            }
        }
        if (!$cliente) {
            echo "No se encontró el socio con número $numSocio.<br>";
            return $this;
        }

        foreach ($numerosProductos as $numeroProducto) {
            try {
                // Utiliza el método individual de devolución que ya actualiza el estado del soporte
                $cliente->devolver($numeroProducto);
                $this->numProductosAlquilados--;
            } catch (SoporteNoEncontradoException $e) {
                echo "<strong>ADVERTENCIA:</strong> " . $e->getMessage() . " (Continuando con las devoluciones restantes...)<br>";
                // Continúa para intentar devolver los otros productos
            }
        }

        return $this;
    }
}
