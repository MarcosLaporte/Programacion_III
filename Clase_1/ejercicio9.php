<?php
/*
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras.

Ejercicio 9

Laporte Marcos
*/

/*$lapicera1 = array(
    'color' => 'azul',
    'marca' => 'bic',
    'trazo' => 'fino',
    'precio'=> 150
);
$lapicera2 = array(
    'color' => 'roja',
    'marca' => 'parker',
    'trazo' => 'grueso',
    'precio'=> 500
);
$lapicera3 = array(
    'color' => 'negra',
    'marca' => 'pelikan',
    'trazo' => 'ultrafino',
    'precio'=> 1000
);*/

$lapicera = array(
    'color' => array('azul', 'roja', 'negra'),
    'marca' => array('bic', 'parker', 'pelikan'),
    'trazo' => array('fino', 'grueso', 'ultrafino'),
    'precio' => array(150, 500, 1000)
);

$lapiceras = array(
    array($lapicera['color'][2], $lapicera['marca'][0], $lapicera['trazo'][0], $lapicera['precio'][0]),
    array($lapicera['color'][1], $lapicera['marca'][1], $lapicera['trazo'][1], $lapicera['precio'][2]),
    array($lapicera['color'][0], $lapicera['marca'][2], $lapicera['trazo'][2], $lapicera['precio'][1])
);

for ($i = 0; $i < count($lapiceras); $i++){
    echo 'Lapicera ' . $i+1 . ': ';
    foreach ($lapiceras[$i] as $valor){
        echo "$valor, ";
    }
    echo '<br>';
}


?>