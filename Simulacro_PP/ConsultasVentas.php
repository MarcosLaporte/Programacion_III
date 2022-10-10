<?php
/* 4-
ConsultasVentas.php: necesito saber :
a- la cantidad de pizzas vendidas
b- el listado de ventas entre dos fechas ordenado por sabor.
c- el listado de ventas de un usuario ingresado
d- el listado de ventas de un  sabor ingresado

Laporte Marcos*/

include_once "Venta.php";

$_arrayVentas = LeerDatosJSON("Ventas.json");
$_pizzasVendidas = 0;
$_ventasF1F2 = array();
$_ventasUsuario = array();
$_ventasSabor = array();

$fechaInicio = DateTime::createFromFormat('d-m-Y', $_POST['fechaInicio']) ? : new DateTime('01-01-2022');
$fechaFinal = DateTime::createFromFormat('d-m-Y', $_POST['fechaFinal']) ? : new DateTime('31-12-2022');
if($fechaFinal < $fechaInicio){
    $auxFecha = $fechaInicio;
    $fechaInicio = $fechaFinal;
    $fechaFinal = $auxFecha;
}

$mail = Venta::MailValido($_POST['mail']) ? $_POST['mail'] : 'invalid_email';

foreach ($_arrayVentas as $venta){
    $fechaPedido = DateTime::createFromFormat('d-m-Y', $venta->_fechaPedido) ? : new DateTime('today');
    $_pizzasVendidas += $venta->_cantidadPizza;
    !callbackEntreDosFechas($fechaPedido, $fechaInicio, $fechaFinal) ? : array_push($_ventasF1F2, $venta);
    callbackVentaUsuario($venta, $mail) ? : array_push($_ventasUsuario, $venta);
    strcmp($_POST['sabor'], $venta->_saborPizza) != 0 ? : array_push($_ventasSabor, $venta);
}

usort($_ventasF1F2, 'callbackSaboresFecha');

/* Impresión de mensajes */

echo "a- Cantidad de pizzas vendidas: $_pizzasVendidas\n";

echo "--------------------------------\n";
if(count($_ventasF1F2) > 0){
    echo "b- Ventas entre " . $fechaInicio->format('d-m-Y') . ' y ' . $fechaFinal->format('d-m-Y') . " ordenadas por sabor: (" . count($_ventasF1F2) . ")\n";
    echo MostrarVentas($_ventasF1F2);
}
else{
    echo "b- No existen ventas entre " . $fechaInicio->format('d-m-Y') . ' y ' . $fechaFinal->format('d-m-Y') . ".\n";
}

echo "--------------------------------\n";
if(count($_ventasUsuario) > 0){
    echo "c- Listado de ventas del usuario " . $_POST['mail'] . ": (" . count($_ventasUsuario) . ")\n";
    echo MostrarVentas($_ventasUsuario);
}else{
    echo "c- No existen ventas del usuario " . $_POST['mail'] . ".\n";
}

echo "--------------------------------\n";
if(count($_ventasSabor) > 0){
    echo "d- Listado de ventas de Pizza de " . $_POST['sabor'] . ": (" . count($_ventasSabor) . ")\n";
    echo MostrarVentas($_ventasSabor);
}else{
    echo "No existen ventas del sabor " . $_POST['sabor'] . ".\n";
}


function callbackEntreDosFechas(DateTime $fechaAChequear, DateTime $fecha1, DateTime $fecha2){
    return $fechaAChequear >= $fecha1 && $fechaAChequear < date_add($fecha2, date_interval_create_from_date_string("1 day"));
}

function callbackVentaUsuario($venta, string $mailUsuario){
    $mailSeparado = explode("@", $venta->_mailUsuario);       
    return strcmp($mailSeparado[0], $mailUsuario) == 0 ? true : false;
}

function callbackSaboresFecha($venta1, $venta2){
    return strcmp($venta1->_saborPizza, $venta2->_saborPizza);
}

function MostrarVentas($ventas){
    $str = '';
    foreach($ventas as $venta){
        $str .= "N° Pedido: $venta->_numeroPedido.\n";
        $str .= "ID: $venta->_id.\n";
        $str .= "Mail de usuario: $venta->_mailUsuario.\n";
        $str .= "Cantidad, sabor y tipo de Pizza: $venta->_cantidadPizza $venta->_saborPizza $venta->_tipoPizza.\n";
        $str .= "Fecha de pedido: $venta->_fechaPedido.\n\n";
    }

    return $str;
}

?>