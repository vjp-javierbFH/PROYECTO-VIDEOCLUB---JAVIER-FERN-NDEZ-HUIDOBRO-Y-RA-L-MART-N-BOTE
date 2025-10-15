<?php
class CintaVideo extends Soporte{
    //Atributo
    private int $duracion;

    // Constructor por parámetro
    public function __construct(int $dur) {
        $this->duracion = $dur;
    }
}