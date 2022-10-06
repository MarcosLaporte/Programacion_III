<?php
/*1B- PizzaCarga.php: (por GET)se ingresa Sabor, precio, Tipo (“molde” o “piedra”), cantidad( de unidades).

Laporte Marcos*/

include_once "Pizza.php";
    
$arrayPizzas = Pizza::LeerDatos();
$arrayPizzas = Add($arrayPizzas);
GuardarDatos($arrayPizzas);

// FUNCIONES ----------------------------------------------------------------

/* Se guardan los datos en en el archivo de texto Pizza.json, tomando un id autoincremental como identificador(emulado). */
function GuardarDatos(array $datos){
    $refArchivo = fopen("Pizza.json", "w+");
    if($refArchivo){
        fwrite($refArchivo, json_encode($datos));
    }
    
    return fclose($refArchivo);
}

/* Sí el sabor y tipo ya existen , se actualiza el precio y se suma al stock existente. */
function Add(array $arrayPizzas){
    $pizza = new Pizza($_GET['sabor'], $_GET['precio'], $_GET['tipo'], $_GET['cantidad']);
    $auxArray = $arrayPizzas;
    $indexPizza = BuscarPizza($arrayPizzas, $pizza);
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

function BuscarPizza(array $pizzasExistentes, Pizza $pizza){
    $ret = -1;
    foreach($pizzasExistentes as $pizzaE){
        if($pizza->Equals($pizzaE)){
            $ret = array_search($pizzaE, $pizzasExistentes);
            break;
        }
    }

    return $ret;
}

?>