<?php

class Dvd extends Soporte
{

    private String $idiomas;
    private String $formatoPantalla;

    public function __construct(String $tit, int $num, float $pre, String $idiomas, String $formatoPantalla)
    {
        parent::__construct($tit, $num, $pre);
        $this->idiomas = $idiomas;
        $this->formatoPantalla = $formatoPantalla;
    }

    public function mostrarDvd(){
        return parent::mostrarSoporte(). ". Dvd: idiomas -> " .$this->idiomas. " y formato de la pantalla -> " .$this->formatoPantalla;
    }
}
