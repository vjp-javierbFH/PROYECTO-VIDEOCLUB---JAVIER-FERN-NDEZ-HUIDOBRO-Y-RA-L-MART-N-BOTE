<?php
class soporte {
    private String $titulo;
    private int $numero;
    private float $precio;

    // Getters
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getNumero()
    {
        return $this->numero;
    }
    public function getPrecio()
    {
        return $this->precio;
    }

    public function mostrarSoporte(): String {
        return "";
    }
}