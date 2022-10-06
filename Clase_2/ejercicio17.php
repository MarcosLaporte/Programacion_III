<?php
/*
Realizar una clase llamada “Auto” que posea los siguientes atributos privados:

_color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble por
parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
    Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);

Ejercicio 17

Laporte Marcos
*/

class Auto {
    private string $_marca;
    private string $_color;
    private float $_precio;
    private DateTime $_fecha;

    public function __construct(string $marca, string $color, float $precio=0, DateTime $fecha= new DateTime()) {
        $this->_marca = $marca;
        $this->_color = $color;
        $this->_precio = $precio;
        $this->_fecha = $fecha;
    }

    public function GetMarca(): string { return $this->_marca; }
    public function GetColor(): string { return $this->_color; }
    public function GetPrecio(): float { return $this->_precio; }
    public function GetFecha(): DateTime { return $this->_fecha; }

    public function AgregarImpuestos(float $impuesto){
        $this->_precio += $impuesto;
    }

    public static function MostrarAuto(Auto $auto){
        return "<br>Marca: $auto->_marca.<br>Color: $auto->_color.<br>
            Precio: $$auto->_precio.<br>Fecha: ".$auto->_fecha->format("d/M/Y").'.<br>';
    }

    public function Equals(Auto $auto){
        return $this->_marca == $auto->_marca;
    }

    public static function Add(Auto $a, Auto $b){
        $_ret = 0;
        if($a->Equals($b) && $a->_color == $b->_color){
            $_ret = $a->_precio + $b->_precio;
        }else{
            echo "No se pueden sumar porque los autos son distintos.<br>";
        }

        return $_ret;
    }
}

?>