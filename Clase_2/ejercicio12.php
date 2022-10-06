<?php

/*
Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
de las letras del Array.
Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.

Ejercicio 12

Laporte Marcos
*/

$_arrChar = array('U', 'T', 'N', ' ', 'F', 'R', 'A');

function FlipString($_string) {
    $_ret = "";
    for($i = count($_string)-1; $i >= 0; $i--) {
        $_ret .= $_string[$i];
    }

    return $_ret;
}
$_flippedString = FlipString($_arrChar);

$_strArrChar = "";
foreach ($_arrChar as $_char){
    $_strArrChar .= $_char;
}

echo $_strArrChar . ' ~~ ' .  $_flippedString;

?>