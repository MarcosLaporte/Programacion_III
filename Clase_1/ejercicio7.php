<?php
/*
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.

Ejercicio 7

Laporte Marcos
*/

$num_vec = array(10);

echo 'FOR:<br>';
for ($i = 0; $i < 10; $i++){
    $num_vec[$i] = (($i+1)*2)-1;
    echo $num_vec[$i] . ' - ';
}

echo '<br>WHILE:<br>';
$contador = 0;
while ($contador < 10){
    echo $num_vec[$contador] . ' - ';
    $contador++;
}

echo '<br>FOREACH:<br>';
foreach ($num_vec as $num){
    echo $num . ' - ';
}

?>