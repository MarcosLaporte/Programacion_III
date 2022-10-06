<?php
/*
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.

Ejercicio 6

Laporte Marcos
*/

$num_vec = array(5);
$acum = 0;

for ($i = 0; $i < 5; $i++){
    $num_vec[$i] = rand(1, 10);
    $acum += $num_vec[$i];
    echo $num_vec[$i] . ' - ';
}

$acum /= 5;
echo "Promedio: $acum <br>";
if($acum > 6)
    echo '<br> El promedio es mayor a 6.';
else if($acum < 6)
    echo '<br> El promedio es menor a 6.';
else
    echo '<br> El promedio es igual a 6.';

?>