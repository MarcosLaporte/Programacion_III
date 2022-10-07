<?php
/*1A- index.php:Recibe todas las peticiones que realiza el postman, y administra a que archivo se debe incluir.

Laporte Marcos*/


switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        echo "Método GET\n";
        include_once "PizzaCarga.php";
        break;
    case 'POST':
        echo "Método POST\n";
        include_once "PizzaConsultar.php";
        include_once "AltaVenta.php";
        break; 
}

?>