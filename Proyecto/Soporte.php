<?php
class Soporte
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

    public function getPrecioConIva() {
        return $this->precio * (1 + self::IVA);
    }

    public function mostrarSoporte(): String
    {
        return "Título: " . $this->titulo . ", número: " . $this->numero . " y precio->" . $this->precio;
    }
}