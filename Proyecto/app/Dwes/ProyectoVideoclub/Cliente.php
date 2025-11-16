<?php
namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Soporte;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;

class Cliente
{
    // === PROPIEDADES (tipos en minúscula) ===
    private string $nombre;
    private int $numero;
    private string $user;
    private string $password;
    private int $maxAlquilerConcurrente;
    private int $numSoportesAlquilados = 0;
    private array $soportesAlquilados = [];

    // === CONSTRUCTOR ===
    public function __construct(string $nombre, int $numero, string $user, string $password)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->user = $user;
        $this->password = $password;
        $this->maxAlquilerConcurrente = 3;
    }

    // === GETTERS ===
    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAlquileres(): array
    {
        return $this->soportesAlquilados;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getNumSoporteAlquilado(): int
    {
        return $this->numSoportesAlquilados;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getSoportesAlquilados(): array
    {
        return $this->soportesAlquilados;
    }

    // === SETTERS (¡NUEVOS!) ===
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function setMaxAlquilerConcurrente(int $maxAlquiler): void
    {
        $this->maxAlquilerConcurrente = $maxAlquiler;
    }

    // === MÉTODOS DE ALQUILER ===
    public function alquilar(Soporte $soporte): self
    {
        if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
            throw new CupoSuperadoException(
                "El cliente {$this->nombre} ha superado el límite de {$this->maxAlquilerConcurrente} alquileres concurrentes.<br>"
            );
        }

        if ($soporte->alquilado) {
            throw new SoporteYaAlquiladoException(
                "El soporte {$soporte->getTitulo()} ya está alquilado por otro cliente.<br>"
            );
        }

        $this->soportesAlquilados[] = $soporte;
        $this->numSoportesAlquilados++;
        $soporte->alquilado = true;

        echo "El soporte {$soporte->getTitulo()} ha sido alquilado correctamente.<br>";

        return $this;
    }

    public function devolver(int $numSoporte): self
    {
        foreach ($this->soportesAlquilados as $key => $soporte) {
            if ($soporte->getNumero() === $numSoporte) {
                $soporte->alquilado = false;
                unset($this->soportesAlquilados[$key]);
                $this->soportesAlquilados = array_values($this->soportesAlquilados);
                $this->numSoportesAlquilados--;

                echo "Soporte {$soporte->getTitulo()} devuelto correctamente.<br>";
                return $this;
            }
        }

        throw new SoporteNoEncontradoException(
            "El cliente no tiene alquilado ningún soporte con número {$numSoporte}.<br>"
        );
    }

    public function listarAlquileres(): void
    {
        $cantidad = count($this->soportesAlquilados);
        echo "<strong>Cliente {$this->nombre} tiene {$cantidad} alquiler(es) actualmente:</strong><br>";

        if ($cantidad === 0) {
            echo "No hay alquileres activos.<br>";
        } else {
            foreach ($this->soportesAlquilados as $soporte) {
                $soporte->muestraResumen();
            }
        }
    }
}