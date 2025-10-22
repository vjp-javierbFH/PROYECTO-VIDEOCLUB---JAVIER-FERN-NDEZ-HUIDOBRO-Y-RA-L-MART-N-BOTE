<?php
namespace Dwes\ProyectoVideoclub\Util;

class CupoSuperadoException extends VideoclubException
{
    public function mostrarError(){
        echo "El cliente ya ha alcanzado el número máximo de alquileres<br>";
    }
}