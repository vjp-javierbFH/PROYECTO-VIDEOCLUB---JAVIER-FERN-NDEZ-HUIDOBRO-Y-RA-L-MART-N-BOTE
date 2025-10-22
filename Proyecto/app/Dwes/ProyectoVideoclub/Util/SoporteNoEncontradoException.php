<?php

namespace Dwes\ProyectoVideoclub\Util;

use Dwes\ProyectoVideoclub\Soporte;

class SoporteNoEncontradoException extends VideoclubException
{
    public function mostrarError(int $numSoporte)
    {
        echo "El cliente no tiene alquilado ningún soporte con número <strong>" . $numSoporte . "</strong><br>";
    }
}
