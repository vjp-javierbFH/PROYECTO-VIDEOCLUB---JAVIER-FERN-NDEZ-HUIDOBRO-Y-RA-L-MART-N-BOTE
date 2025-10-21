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
    private int $maxAlquilerConcurrente;
    private int $numSoportesAlquilados = 0; // Lo inicializo a 0
    private array $soportesAlquilados = []; // Array que contendrá 


    // Constructor por parámetro de nombre y numero
    public function __construct(String $nombre, int $numero)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->maxAlquilerConcurrente = 3; // Inicializo la variable maxAlquilerConcurrente por defecto a 3
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

    // Método que muestra los datos de clientes
    public function mostrarCliente()
    {
        echo "<strong>Cliente:</strong> " . $this->nombre . "<br>";
        echo "Número de cliente: " . $this->numero . "<br>";
        // Con count muestra el número de índices que tiene el array
        echo "Alquileres actuales: " . count($this->soportesAlquilados) . "<br>";
        echo "Total de soportes alquilados: {$this->numSoportesAlquilados}<br>";
    }

    // Métodos
    // Método que recorre el array para comprobar si está el objeto de la clase Soporte
    public function tieneAlquilado(Soporte $s): bool
    {
        foreach ($this->soportesAlquilados as $soporte) {
            // Compara por número de soporte
            if ($soporte->getNumero() === $s->getNumero()) {
                return true;
            }
        }
        return false;
    }

    // Método para alquilar soporte
    public function alquilar(Soporte $s): Cliente
    {
        // Con el método tieneAlquilado verificamos si el soporte está alquiladp
        if ($this->tieneAlquilado($s)) {
            throw new SoporteYaAlquiladoException("El cliente ya ha alquilado el soporte.<br>" . $s->getTitulo());
        }

        // Si número de índices del array supera o iguala al maxAlquilerConcurrente devolverá false
        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException("El cliente ha alcanzado el numero maximo de alquileres.<br>");
        }

        // Almaceno el soporte al array soportesAlquilados
        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++; // Incremento más uno el número de soportes alquilados

        //Soportes alquilados: establece el estado en Soporte
        $s->alquilado = true;

        return $this;
    }

    // Método que devuelve el soporte por su número
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
                echo "- " . $soporte->mostrarResumen();
            }
        }
    }
}
