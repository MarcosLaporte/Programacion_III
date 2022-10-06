<?php
/*
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.

Ejercicio 1

Laporte Marcos
*/

$numero = 1;
$acumulador = 0;
$contador = 0;

while($acumulador+$numero <= 1000){
    echo $acumulador. "+" . $numero . "=" . $acumulador+$numero . "<br>";
    $acumulador += $numero;
    $numero++;
    $contador++;
}

echo "Se sumaron " . $contador . " números. (" . $acumulador . ")";


?>