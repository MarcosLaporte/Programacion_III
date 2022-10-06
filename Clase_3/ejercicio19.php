<?php
/*
Realizar una clase llamada “Auto” que posea los siguientes atributos

privados: _color (String)
_precio (Double)
_marca (String).
_fecha (DateTime)

Realizar un constructor capaz de poder instanciar objetos pasándole como

parámetros: i. La marca y el color.
ii. La marca, color y el precio.
iii. La marca, color, precio y fecha.

Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble
por parámetro y que se sumará al precio del objeto.
Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto”
por parámetro y que mostrará todos los atributos de dicho objeto.
Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
devolverá TRUE si ambos “Autos” son de la misma marca.
Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son
de la misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con
la suma de los precios o cero si no se pudo realizar la operación.
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un
archivo autos.csv.
Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo
autos.csv
Se deben cargar los datos en un array de autos.

Ejercicio 19

Laporte Marcos
*/

class Auto{
    private string $_color;
    private float $_precio;
    private string $_marca;
    private DateTime $_fecha;

    public function __construct(string $marca, string $color, float $precio = 150000, DateTime $fecha = new DateTime('now')){
        $this->_marca = $marca;
        $this->_color = $color;
        $precio < 0 ? $this->_precio = 15000 : $this->_precio = $precio;
        $fecha->format("d/m/y");
        $this->_fecha = $fecha;
    }

    public function AgregarImpuestos(float $impuesto){
        $this->_precio += $impuesto;
    }

    public static function MostrarAuto(Auto $auto){
        return $auto->_marca . " " . $auto->_color . ': $' . $auto->_precio . ' - ' . $auto->_fecha->format("d/m/y") . "<br>";
    }

    public function Equals(Auto $a){
        return $this->_marca == $a->_marca;
    }

    public static function Add(Auto $a, Auto $b){
        $ret = -1;
        if($a->Equals($b) && $a->_color == $b->_color){
            $ret = $a->_precio + $b->_precio;
        }else{
            echo "No se pueden sumar porque los autos son distintos.<br>";
        }

        return $ret;
    }
    
    public static function AltaAutos($arrayAuto){
        $refArchivo = fopen("autos.csv", "w");
        
        if($refArchivo){
            foreach($arrayAuto as $auto){
                $cadenaAuto = $auto->_marca . ',' . $auto->_color . ',' . $auto->_precio . ',' . $auto->_fecha->format("d/m/y") . "\n";
                fwrite($refArchivo, $cadenaAuto);
            }
        }

        return fclose($refArchivo);
    }

    public static function LeerArchivo(){
        $refArchivo = fopen("autos.csv", "r");
        $arrayAtributos = array();
        $autos = array();

        if($refArchivo){
            while(!feof($refArchivo)){
                $arrayAtributos = fgetcsv($refArchivo);
                if(!empty($arrayAtributos)){
                    $auto = new Auto($arrayAtributos[0], $arrayAtributos[1], $arrayAtributos[2], new DateTime($arrayAtributos[3]));
                    array_push($autos, $auto);
                }
            }
        }

        fclose($refArchivo);
        
        return $autos;
    }
}

?>