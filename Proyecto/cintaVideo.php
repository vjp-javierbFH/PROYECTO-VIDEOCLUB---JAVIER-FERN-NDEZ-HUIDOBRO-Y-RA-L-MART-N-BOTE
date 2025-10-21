<?php
namespace Dwes\ProyectoVideoclub;
// Clase CintaVideo
include_once "Soporte.php";
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
    public function mostrarResumen()
    {
        echo "Título: " . $this->titulo . ", número -> " . $this->numero . ", precio -> " . $this->precio . " €";
        echo ". Duración: " . $this->duracion . " minutos<br>";
    }

    // Método de la interfaz Resumible
    public function muestraResumen(): void {
        $this->mostrarResumen();
    }
}
