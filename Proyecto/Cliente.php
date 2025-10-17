<?php
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
    public function alquilar(Soporte $s): bool
    {
        // Con el método tieneAlquilado verificamos si el soporte está alquiladp
        if ($this->tieneAlquilado($s)) {
            echo "El cliente ya ha alquilado el soporte " . $s->getTitulo();
            return false;
        }

        if (count($this->soportesAlquilados) >= $this->maxAlquilerConcurrente) {
            echo "El cliente ha alcanzado el número máximo de alquileres";
            return false;
        }

        // Almaceno el soporte al array soportesAlquilados
        $this->soportesAlquilados[] = $s;
        $this->numSoportesAlquilados++; // Incremento más uno el número de soportes alquilados
        return false;
    }
}
