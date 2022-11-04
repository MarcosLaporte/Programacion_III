<?php
/*1A- index.php:Recibe todas las peticiones que realiza el postman, y administra a qué archivo se debe incluir.

Laporte Marcos*/


switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        echo "Método POST\n";
        switch ($_POST['funcion']) {
            case 'nuevoHelado':
                include_once "HeladeriaAlta.php";
                break;
            case 'nuevaVenta':
                include_once "AltaVenta.php";
                break;
            case 'consultaHelados':
                include_once "HeladoConsultar.php";
                break;
            case 'heladoRancio':
                include_once "DevolverHelado.php";
                break;
            default:
                echo "Error! Escoja una función válida:\n";
                echo "~ nuevoHelado\n~ nuevaVenta\n~ consultaHelados\n~ heladoRancio\n";
        }
        break;
    case 'GET':
        echo "Método GET\n";
        if (!strcasecmp($_GET['motivo'], 'ventas'))
            include_once "ConsultarVentas.php";
        else if (!strcasecmp($_GET['motivo'], 'devoluciones'))
            include_once "ConsultarDevoluciones.php";
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
