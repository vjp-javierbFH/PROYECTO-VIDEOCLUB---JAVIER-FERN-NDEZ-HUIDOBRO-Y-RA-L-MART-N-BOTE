<?php
// Clase CintaVideo
include "Soporte.php";
class CintaVideo extends Soporte
{
    //Atributo
    private int $duracion;

    // Constructor por parámetro
    public function __construct(String $tit, int $num, float $pre, int $dur)
    {
        // Constructor de la clase padre
        parent::__construct($tit, $num, $pre);
        $this->duracion = $dur;
    }

    // Método que muestra los datos de  CintaVideo
    public function mostrarCintaVideo()
    {
        // Llama al método mostrarSoporte de la clase padre
        parent::mostrarSoporte();
        echo ". Duración: " . $this->duracion . " minutos<br>";
    }
}
