<?php

/*
Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

Ejercicio 5

Laporte Marcos
*/

$num = rand(20, 60);
if($num < 20)
    $num = 20;
else if($num > 60)
    $num = 60;

$prim_digito = strval($num)[0];
$seg_digito = strval($num)[1];
$num_nombre = "";

switch ($prim_digito){
    case 2:
        if($seg_digito != 0)
            $num_nombre = "veinti";
        else
            $num_nombre = "veinte";
        break;
    case 3:
        $num_nombre = "treinta";
        break;
    case 4:
        $num_nombre = "cuarenta";
        break;
    case 5:
        $num_nombre = "cincuenta";
        break;
    case 6:
        $num_nombre = "sesenta";
        break;
}

if($prim_digito != 2 && $prim_digito != 6 && $seg_digito != 0)
    $num_nombre .= " y ";

switch ($seg_digito){
    case 1:
        $num_nombre .= "uno";
        break;
    case 2:
        $num_nombre .= "dos";
        break;
    case 3:
        $num_nombre .= "tres";
        break;
    case 4:
        $num_nombre .= "cuatro";
        break;
    case 5:
        $num_nombre .= "cinco";
        break;
    case 6:
        $num_nombre .= "seis";
        break;
    case 7:
        $num_nombre .= "siete";
        break;
    case 8:
        $num_nombre .= "ocho";
        break;
    case 9:
        $num_nombre .= "nueve";
        break;
}

echo "$num = $num_nombre.";

?>