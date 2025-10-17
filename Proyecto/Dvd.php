<?php
// Clase Dvd que hereda de Soporte
class Dvd extends Soporte
{
    // Atributos
    private String $idiomas;
    private String $formatoPantalla;

    // Constructor por parámetro junto con el constructor de la clase padre
    public function __construct(String $tit, int $num, float $pre, String $idiomas, String $formatoPantalla)
    {
        parent::__construct($tit, $num, $pre);
        $this->idiomas = $idiomas;
        $this->formatoPantalla = $formatoPantalla;
    }

    // Método que muestra los datos del Dvd junto con los de la clase padre
    public function mostrarResumen()
    {
        echo "Título: ".$this->getTitulo().", número -> " .$this->getNumero()." y precio -> " .$this->getPrecio();
        echo ". Dvd: idiomas -> " . $this->idiomas . " y formato de la pantalla -> " . $this->formatoPantalla . "<br>";
    }
}
