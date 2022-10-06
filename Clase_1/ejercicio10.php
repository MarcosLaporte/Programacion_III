<?php
/*
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.

Ejercicio 10

Laporte Marcos
*/

$vec = array(
    "lapicera1" => array('negra', 'bic', 'fino', 150),
    "lapicera2" => array('roja', 'parker', 'grueso', 1000),
    "lapicera3" => array('azul', 'pelikan', 'ultrafino', 500)
);

for ($i = 1; $i < count($vec)+1; $i++){
    echo 'Lapicera ' . $i. ': ';
    foreach ($vec["lapicera$i"] as $valor){
        echo "$valor, ";
    }
    echo '<br>';
}

?>