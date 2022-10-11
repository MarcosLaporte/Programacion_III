<?php
/*1A- index.php:Recibe todas las peticiones que realiza el postman, y administra a que archivo se debe incluir.

Laporte Marcos*/

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        echo "Método POST\n";
        switch ($_POST['funcion']) {
            case '':
                include_once "PizzaCarga.php";
                break;
            case 'nuevaVenta':
                include_once "AltaVenta.php";
                break;
            case 'consultaPizzas':
                include_once "PizzaConsultar.php";
                break;
            case 'consultaVentas':
                include_once "ConsultasVentas.php";
                break;
            default:
                echo "Error! Escoja una función válida:\n";
                echo "~ nuevaPizza\n~ nuevaVenta\n~ consultaPizzas\n~ consultaVentas\n";
        }
        break;
    case 'PUT':
        echo "Método PUT\n";
        include_once "ModificarVenta.php";
        break;
        case 'DELETE':
        echo "Método DELETE\n";
        include_once "BorrarVenta.php";
        break;
}

?>