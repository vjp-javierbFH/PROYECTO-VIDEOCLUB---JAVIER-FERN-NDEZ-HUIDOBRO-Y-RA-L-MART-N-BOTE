<?php
// Clase CintaVideo
// Referencio a la clase Soporte para que al ejecutar 
class CintaVideo extends Soporte
{
    //Atributo
    private int $duracion;

    // Constructor por parámetro
    public function __construct(String $tit, int $num, float $pre, int $dur)
    {
        parent::__construct($tit, $num, $pre);
        $this->duracion = $dur;
    }

    public function mostrarCintaVideo()
    {
        return parent::mostrarSoporte() . ". Duración: " . $this->duracion;
    }
}
