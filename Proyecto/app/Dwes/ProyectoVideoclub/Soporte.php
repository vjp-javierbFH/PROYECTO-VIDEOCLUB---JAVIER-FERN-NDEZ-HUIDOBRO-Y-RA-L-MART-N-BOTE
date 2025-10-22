<?php
namespace Dwes\ProyectoVideoclub;
include_once "Resumible.php";
abstract class Soporte implements Resumible
{
    // Constante IVA
    protected const IVA = 0.21;

    // Atributos protected para que las subclases hereden los atributos
    protected String $titulo;
    protected int $numero;
    protected float $precio;
    public bool $alquilado = false; // Atributo público para saber si el cliente tiene alquileres

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
    public function getPrecioConIva()
    {
        return $this->precio * (1 + self::IVA);
    }

    // Método base
    public function mostrarSoporte()
    {
        return "Título: " . $this->titulo . ", número -> " . $this->numero . ", precio -> " . $this->precio . " €";
    }

    // Implementación del método obligatorio del interfaz
    public function muestraResumen(): void
    {
        echo $this->mostrarSoporte() . "<br>";
    }

}
