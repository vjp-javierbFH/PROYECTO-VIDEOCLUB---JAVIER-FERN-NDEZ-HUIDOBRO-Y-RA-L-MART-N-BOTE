<?php
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
        echo "Título: ".$this->getTitulo().", número -> " .$this->getNumero()." y precio -> " .$this->getPrecio();
        echo ". Duración: " . $this->duracion . " minutos<br>";
    }
}
