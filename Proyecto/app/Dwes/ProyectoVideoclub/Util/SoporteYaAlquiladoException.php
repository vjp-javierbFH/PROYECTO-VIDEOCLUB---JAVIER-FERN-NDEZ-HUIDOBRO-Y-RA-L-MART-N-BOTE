<?php

namespace Dwes\ProyectoVideoclub\Util;

use Dwes\ProyectoVideoclub\Soporte;

class SoporteYaAlquiladoException extends VideoclubException
{
    public function mostrarError(Soporte $s)
    {

        echo ("El cliente ya ha alquilado el soporte: <strong>" . $s->getTitulo() . "</strong><br>");
    }
}
