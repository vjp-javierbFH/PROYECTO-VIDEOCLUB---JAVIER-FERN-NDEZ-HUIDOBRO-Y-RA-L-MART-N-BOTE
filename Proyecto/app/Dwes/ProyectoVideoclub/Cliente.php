<?php
namespace Dwes\ProyectoVideoclub;
use Dwes\ProyectoVideoclub\Soporte;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
// Clase Cliente
class Cliente
{
    // Atributos
    private String $nombre;
    private int $numero;
    private string $user; // NUEVO: Usuario del cliente
    private string $password; // NUEVO: Contraseña del cliente
    private int $maxAlquilerConcurrente;
    private int $numSoportesAlquilados = 0; // Lo inicializo a 0
    private array $soportesAlquilados = []; // Array que contendrá 


    // Constructor por parámetro de nombre, numero, user y password (MODIFICADO)
    // El constructor ahora recibe 4 argumentos
    public function __construct(String $nombre, int $numero, string $user, string $password)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->user = $user;
        $this->password = $password;
        $this->maxAlquilerConcurrente = 3; // Inicializo la variable maxAlquilerConcurrente por defecto a 3
    }
    
    // Getter para el usuario (NUEVO)
    public function getUser(): string
    {
        return $this->user;
    }

    // Getter para la password (NUEVO)
    public function getPassword(): string
    {
        return $this->password;
    }

    // Método para obtener los alquileres del cliente (NUEVO)
    public function getAlquileres(): array
    {
        return $this->soportesAlquilados;
    }

    // Getter y Setter de la variable numero
    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $num)
    {
        $this->numero = $num;
    }

    // Getter de numSoportesAlquilados
    public function getNumSoporteAlquilado(): int
    {
        return $this->numSoportesAlquilados;
    }

    // Getter de nombre
    public function getNombre(): String
    {
        return $this->nombre;
    }

    // Getter de soportesAlquilados
    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }

    // Setter de maxAlquilerConcurrente
    public function setMaxAlquilerConcurrente(int $maxAlquiler): void
    {
        $this->maxAlquilerConcurrente = $maxAlquiler;
    }

    // Método para alquilar un soporte
    public function alquilar(Soporte $soporte): Cliente
    {
        // Comprobar si el cupo de alquileres se ha superado
        if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("El cliente " . $this->nombre . " ha superado el límite de " . $this->maxAlquilerConcurrente . " alquileres concurrentes.<br>");
        }

        // Comprobar si el soporte ya está alquilado por el cliente
        // Si el soporte estuviera en la sesión del admin, su estado alquilado=true
        if ($soporte->alquilado) {
            // Nota: Este mensaje de error es un poco engañoso si el soporte está alquilado por el mismo cliente
            // Pero para el ejercicio, nos basamos en que la disponibilidad la gestiona la propiedad $alquilado del Soporte.
            throw new SoporteYaAlquiladoException("El soporte " . $soporte->getTitulo() . " ya está alquilado por otro cliente/usuario.<br>");
        }

        // Alquilar el soporte
        $this->soportesAlquilados[] = $soporte;
        $this->numSoportesAlquilados++;

        // Establece el estado en Soporte
        $soporte->alquilado = true;

        echo "El soporte " . $soporte->getTitulo() . " ha sido alquilado correctamente.<br>";

        return $this;
    }

    // Método para devolver un soporte
    public function devolver(int $numSoporte): Cliente
    {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                //Soportes devueltos: establece el estado en Soporte
                $soporte->alquilado = false;

                unset($this->soportesAlquilados[$key]); // eliminar del array
                // Reescribe los índices desde 0 tras eliminar un índice del array
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                echo "Soporte " . $soporte->getTitulo() . " devuelto correctamente.<br>";
                return $this;
            }
        }
        throw new SoporteNoEncontradoException("El cliente no tiene alquilado ningún soporte con número " . $numSoporte . ".<br>");
    }

    // Método que lista todos los soportes
    public function listarAlquileres(): void
    {
        $cantidad = count($this->soportesAlquilados);
        echo "<strong>Cliente " . $this->nombre . " tiene " . $cantidad . " alquiler(es) actualmente:</strong><br>";
        // Si no hay ningún objeto Soporte en el array soportesAlquilados mostrará que no hay alquileres
        if ($cantidad === 0) {
            echo "No hay alquileres activos.<br>";
        } else {
            // Recorre el array para mostrar los datos de soporte
            foreach ($this->soportesAlquilados as $soporte) {
                $soporte->muestraResumen();
            }
        }
    }
}