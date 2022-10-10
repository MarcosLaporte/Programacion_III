<?php
/*1A- index.php:Recibe todas las peticiones que realiza el postman, y administra a que archivo se debe incluir.

Laporte Marcos*/


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo "Método GET\n";
        include_once "PizzaCarga.php";
        break;
    case 'POST':
        echo "Método POST\n";
        switch ($_POST['funcion']) {
            case 'consultaPizzas':
                include_once "PizzaConsultar.php";
                break;
            case 'consultaVentas':
                include_once "ConsultasVentas.php";
                break;
            case 'alta':
                include_once "AltaVenta.php";
                break;
            default:
                echo "Error! Escoja una función válida:\n";
                echo "~ consultaPizzas\n~ consultaVentas\n~ alta\n";
        }
        break;
}

?>