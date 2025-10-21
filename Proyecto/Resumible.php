<?php
namespace Dwes\ProyectoVideoclub;
interface Resumible
{
    // Obliga a las clases que lo implementen a definir este método
    public function muestraResumen(): void;
}