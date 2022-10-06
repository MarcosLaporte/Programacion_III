<?php

/*
Dadas tres variables numéricas de tipo entero $a, $b y $c realizar una aplicación que muestre
el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres
variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido.
    Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
    Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”

Ejercicio 3

Laporte Marcos
*/

$a = -1;
$b = 1;
$c = 4;

echo "Los valores son: $a / $b / $c.<br>";

if(($a < $b && $a > $c) || ($a > $b && $a < $c))
    echo "El valor del medio es $a.";
else if(($b < $a && $b > $c) || ($b > $a && $b < $c))
    echo "El valor del medio es $b.";
else if(($c < $a && $c > $b) || ($c > $a && $c < $b))
    echo "El valor del medio es $c.";
else
    echo 'No hay valor del medio.';
?>