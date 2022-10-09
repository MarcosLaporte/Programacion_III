<?php
/*1B- PizzaCarga.php: (por GET)se ingresa Sabor, precio, Tipo (“molde” o “piedra”), cantidad( de unidades).

Laporte Marcos */

include_once "Pizza.php";
    
$arrayPizzas = LeerDatosJSON("Pizza.json");
$arrayPizzas = AddPizza($arrayPizzas);
/* Se guardan los datos en en el archivo de texto Pizza.json, tomando un id autoincremental como identificador(emulado). */
GuardarDatosJSON($arrayPizzas, "Pizza.json");

// FUNCIONES ----------------------------------------------------------------

/* Sí el sabor y tipo ya existen , se actualiza el precio y se suma al stock existente. */
function AddPizza(array $arrayPizzas){
    $pizza = new Pizza($_GET['sabor'], $_GET['precio'], $_GET['tipo'], $_GET['cantidad']);
    $auxArray = $arrayPizzas;
    $indexPizza = Pizza::BuscarPizza($arrayPizzas, $pizza);

    if($indexPizza != -1){
        $auxArray[$indexPizza]->_precio = $pizza->_precio;
        $auxArray[$indexPizza]->_cantidad += $pizza->_cantidad;
        echo "Se actualizó el stock!:\n";
        echo $auxArray[$indexPizza]->_cantidad . ' pizza/s sabor ' . $auxArray[$indexPizza]->_sabor . ' tipo ' . $auxArray[$indexPizza]->_tipo . ' por $' . $auxArray[$indexPizza]->_precio . "\n";
    }else{
        array_push($auxArray, $pizza);
        echo "Se agregó una pizza!:\n";
        echo $pizza->_cantidad . ' pizza/s sabor ' . $pizza->_sabor . ' tipo ' . $pizza->_tipo . ' por $' . $pizza->_precio . "\n";
    }

    return $auxArray;
}


?>