<?php
/*
En testAuto.php:
● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5).

Ejercicio 17

Laporte Marcos
*/
require_once "ejercicio17.php";

$autos = array(
    $_auto1 = new Auto("Ford", "Rojo", rand(100000, 1000000)),
    $_auto2 = new Auto("Ford", "Negro", rand(100000, 750000)),
    $_auto3 = new Auto("Renault", "Blanco", 200000),
    $_auto4 = new Auto("Renault", "Blanco", 250000),
    $_auto5 = new Auto("Ferrari", "Verde", 125000000, new DateTime("05/08/03"))
);

for ($i = 0; $i < 3; $i++){
    $autos[$i]->AgregarImpuestos(150);
}

$_precio2Autos = Auto::Add($autos[0], $autos[1]);
if($_precio2Autos != 0)
    echo 'Los primeros dos autos suman un total de: $' . $_precio2Autos . '<br>';

$_auto2igual5 = $autos[1]->Equals($autos[4]);
if($_auto2igual5)
    echo 'Los autos #2 y #5 son iguales!<br>';
else
    echo 'Los autos #2 y #5 no son iguales!<br>';

for($i = 0; $i < count($autos); $i++){
    if(($i+1)%2!=0){
        echo '<br>Auto #' . $i+1 . ':<br>';
        echo Auto::MostrarAuto($autos[$i]); 
    }
}
?>