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
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo). Ejemplo:
$miGarage->Remove($autoUno);
Crear un método de clase para poder hacer el alta de un Garage y, guardando los datos en un
archivo garages.csv.
Hacer los métodos necesarios en la clase Garage para poder leer el listado desde el archivo
garage.csv
Se deben cargar los datos en un array de garage.

Ejercicio 20

Laporte Marcos
*/

require_once "ejercicio19.php";

class Garage{
    private string $_razonSocial;
    private float $_precioPorHora;
    private $_autos;

    public function __construct($razonSocial, $precioPorHora = 300){
        $this->_razonSocial = $razonSocial;
        $this->_precioPorHora = $precioPorHora;
        $this->_autos = array();
    }

    public function MostrarGarage(){
        return 'Garage "' . $this->_razonSocial . '". $' . $this->_precioPorHora . '/h\n';
    }

    public function Equals(Auto $autoPlus){
        $ret = false;

        foreach($this->_autos as $auto){
            if($auto->equals($autoPlus)){
                $ret = true;
                break;
            }
        }

        return $ret;
    }

    public function Add(Auto $auto){
        $ret = false;
        if(!$this->Equals($auto)){
            array_push($this->_autos, $auto);
            $ret = true;
        }

        return $ret;
    }
    
    public function Remove(Auto $auto){
        $ret = false;
        if($this->Equals($auto)){
            $indice = array_search($auto, $this->_autos);
            unset($this->_autos[$indice]);
            $ret = true;
        }

        return $ret;
    }

    public static function AltaGarage(Garage $garage){
        $refArchivo = fopen("garages.csv", "w");

        
    }

}



?>