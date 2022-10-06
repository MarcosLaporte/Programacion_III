<?php
/*
Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado. 0 en caso contrario.

Ejercicio 13

Laporte Marcos
*/

function ValidateCharSize($_palabra, $_max){
    $_ret = 1;
    
    if (strlen($_palabra) > $_max || ($_palabra != "Recuperatorio" && $_palabra != "Programacion" && $_palabra != "Parcial")){
        $_ret = 0;
    }

    return $_ret;
}

$_miPalabra = "Parcial";

if (ValidateCharSize($_miPalabra, 13) == 1){
    echo 'La palabra concuerda!';
}else{
    echo 'La palabra no concuerda!';
}

?>