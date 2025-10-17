<?php
abstract class Soporte
{
    // Constante IVA
    private const IVA = 0.21;

    // Atributo
    private String $titulo;
    private int $numero;
    private float $precio;

    // Constructor por parámetro
    public function __construct(String $tit, int $num, float $pre)
    {
        $this->titulo = $tit;
        $this->numero = $num;
        $this->precio = $pre;
    }

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

    // Método que devuelve un float
    public function getPrecioConIva() {
        return $this->precio * (1 + self::IVA);
    }

    // Método que muestra los datos de soporte
    abstract public function mostrarResumen();
}