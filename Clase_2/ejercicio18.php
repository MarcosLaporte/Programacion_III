<?php
/*
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los métodos.

Ejercicio 18

Laporte Marcos
*/
require_once "ejercicio17.php";

class Garage{
    private string $_razonSocial;
    private float $_precioPorHora;
    private array $_autos = array();

    public function __construct(string $razonSocial, float $precioPorHora = 150){
        $this->_razonSocial = $razonSocial;
        $this->_precioPorHora = $precioPorHora;
    }

    public function MostrarGarage(){
        $i = 1;
        echo "<br>Razón Social: $this->_razonSocial. $$this->_precioPorHora/hr.<br><br>Autos:<br>";
        foreach ($this->_autos as $_auto){
            echo 'Auto #' . $i;
            echo Auto::MostrarAuto($_auto) . '<br>';
            $i++;
        }
    }

    public function Equals(Auto $a){
        $_ret = false;
        foreach ($this->_autos as $_auto){
            if ($_auto->Equals($a) && $_auto->GetColor() == $a->GetColor() && $_auto->GetPrecio() == $a->GetPrecio()){
                $_ret = true;
                break;
            }
        }

        return $_ret;
    }

    public function Add(Auto $a){
        $_ret = false;
        if(!$this->Equals($a)){
            array_push($this->_autos, $a);
            $_ret = true;
        }

        return $_ret;
    }

    public function Remove(Auto $a){
        $_ret = false;
        if($this->Equals($a)){
            $_key = array_search($a, $this->_autos);
            unset($this->_autos[$_key]);
            $_ret = true;
        }

        return $_ret;
    }


}


?>