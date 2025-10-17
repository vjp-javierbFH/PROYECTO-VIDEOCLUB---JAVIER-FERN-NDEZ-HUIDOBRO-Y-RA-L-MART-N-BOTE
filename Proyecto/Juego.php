<?php
// Clase Juego que hereda de la clase Soporte
class Juego extends Soporte
{
    // Atributos
    private String $consola;
    private int $minNumJugadores;
    private int $maxNumJugadores;

    // Constructor por parámetro
    public function __construct(String $tit, int $num, float $pre, String $concola, int $minNumJugadores, int $maxNumJugadores)
    {
        parent::__construct($tit, $num, $pre);
        $this->consola = $concola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    // Método que muestra los datos del juego
    public function mostrarJuego()
    {
        // Llamo al método mostrarSoporte de la clase padre Soporte
        parent::mostrarSoporte();
        echo ". Juego: consola -> " . $this->consola .
            ", número mínimo de jugadores: " . $this->minNumJugadores .
            ", número máximo de jugadores: " . $this->maxNumJugadores . "<br>";
    }
}
