<?php
/* 4-
ConsultasVentas.php: (por GET)
Datos a consultar:
a- La cantidad de Helados vendidos en un día en particular(se envía por parámetro),
    si no se pasa fecha, se muestran las del día de ayer.
b- El listado de ventas de un usuario ingresado.
c- El listado de ventas entre dos fechas ordenado por nombre.
d- El listado de ventas por sabor ingresado.

Laporte Marcos*/

include_once "Venta.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_heladosVendidos = 0;
$_ventasF1F2 = array();
$_ventasUsuario = array();
$_ventasSabor = array();

$fechaInicio = DateTime::createFromFormat('d-m-Y', $_GET['fechaInicio']) ? new DateTime ($_GET['fechaInicio']) : new DateTime('01-01-2022');
$fechaFinal = DateTime::createFromFormat('d-m-Y', $_GET['fechaFinal']) ? new DateTime ($_GET['fechaFinal']) : new DateTime('31-12-2022');
$fechaConsulta = DateTime::createFromFormat('d-m-Y', $_GET['fechaPedido']) ? new DateTime ($_GET['fechaPedido']) : new DateTime('yesterday');
if($fechaFinal < $fechaInicio){
    $auxFecha = $fechaInicio;
    $fechaInicio = $fechaFinal;
    $fechaFinal = $auxFecha;
}

$mail = Venta::MailValido($_GET['mail']) ? $_GET['mail'] : 'invalid_email';

foreach ($_arrayVentas as $venta){
    $fechaPedido = DateTime::createFromFormat('d-m-Y', $venta->_fechaPedido) ? new DateTime($venta->_fechaPedido) : new DateTime('today');
    $_heladosVendidos += $venta->_fechaPedido == $fechaConsulta ? $venta->_stockHelado : 0;
    !callbackEntreDosFechas($fechaPedido, $fechaInicio, $fechaFinal) ? : array_push($_ventasF1F2, $venta);
    callbackVentaUsuario($venta, $mail) ? : array_push($_ventasUsuario, $venta);
    strcmp($_GET['sabor'], $venta->_saborHelado) != 0 ? : array_push($_ventasSabor, $venta);
}

usort($_ventasF1F2, 'callbackSaboresFecha');

/* Impresión de mensajes */

echo "a- Cantidad de helados vendidos el ". $fechaConsulta->format('dd-mm-YY') .": $_heladosVendidos\n";

echo "--------------------------------\n";
if(count($_ventasUsuario) > 0){
    echo "b- Listado de ventas del usuario " . $_GET['mail'] . ": (" . count($_ventasUsuario) . ")\n";
    echo MostrarVentas($_ventasUsuario);
}else{
    echo "b- No existen ventas del usuario " . $_GET['mail'] . ".\n";
}

echo "--------------------------------\n";
if(count($_ventasF1F2) > 0){
    echo "c- Ventas entre " . $fechaInicio->format('d-m-Y') . ' y ' . $fechaFinal->format('d-m-Y') . " ordenadas por sabor: (" . count($_ventasF1F2) . ")\n";
    echo MostrarVentas($_ventasF1F2);
}
else{
    echo "c- No existen ventas entre " . $fechaInicio->format('d-m-Y') . ' y ' . $fechaFinal->format('d-m-Y') . ".\n";
}

echo "--------------------------------\n";
if(count($_ventasSabor) > 0){
    echo "d- Listado de ventas de Helado de " . $_GET['sabor'] . ": (" . count($_ventasSabor) . ")\n";
    echo MostrarVentas($_ventasSabor);
}else{
    echo "No existen ventas del sabor " . $_GET['sabor'] . ".\n";
}


function callbackEntreDosFechas(DateTime $fechaAChequear, DateTime $fecha1, DateTime $fecha2){
    return $fechaAChequear >= $fecha1 && $fechaAChequear < date_add($fecha2, date_interval_create_from_date_string("1 day"));
}

function callbackVentaUsuario($venta, string $mailUsuario){
    $mailSeparado = explode("@", $venta->_mailUsuario);       
    return strcasecmp($mailSeparado[0], $mailUsuario) == 0 ? true : false;
}

function callbackSaboresFecha($venta1, $venta2){
    return strcasecmp($venta1->_saborHelado, $venta2->_saborHelado);
}

function MostrarVentas($ventas){
    $str = '';
    foreach($ventas as $venta){
        $str .= "N° Pedido: $venta->_numeroPedido.\n";
        $str .= "ID: $venta->_id.\n";
        $str .= "Mail de usuario: $venta->_mailUsuario.\n";
        $str .= "Cantidad, sabor y tipo de Helado: $venta->_stockHelado $venta->_saborHelado $venta->_tipoHelado.\n";
        $str .= "Fecha de pedido: $venta->_fechaPedido.\n\n";
    }

    return $str;
}

?>