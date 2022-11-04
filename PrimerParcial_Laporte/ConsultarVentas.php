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

include_once "Clases\\Venta.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_heladosVendidos = 0;
$_ventasF1F2 = array();
$_ventasUsuario = array();
$_ventasSabor = array();

$fechaInicio = DateTime::createFromFormat('d-m-Y', $_GET['fechaInicio']) ? new DateTime($_GET['fechaInicio']) : new DateTime('01-01-2022');
$fechaFinal = DateTime::createFromFormat('d-m-Y', $_GET['fechaFinal']) ? new DateTime($_GET['fechaFinal']) : new DateTime('31-12-2022');
$fechaConsulta = DateTime::createFromFormat('d-m-Y', $_GET['fechaPedido']) ? new DateTime($_GET['fechaPedido']) : new DateTime('yesterday');

if ($fechaFinal < $fechaInicio) {
    $auxFecha = $fechaInicio;
    $fechaInicio = $fechaFinal;
    $fechaFinal = $auxFecha;
}

$mail = Venta::MailValido($_GET['mail']) ? $_GET['mail'] : 'invalid_email';
$sabor = empty($_GET['sabor']) ? 'invalid_sabor' : $_GET['sabor'];

if (strcasecmp($mail, 'invalid_email') && strcasecmp($sabor, 'invalid_sabor')) {
    foreach ($_arrayVentas as $venta) {
        $fechaVenta = new DateTime($venta->_fechaPedido);
        $_heladosVendidos += $fechaVenta == $fechaConsulta ? $venta->_cantHelado : 0;

        $fechaPedido = DateTime::createFromFormat('d-m-Y', $venta->_fechaPedido) ? new DateTime($venta->_fechaPedido) : new DateTime('today');
        !callbackEntreDosFechas($fechaPedido, $fechaInicio, $fechaFinal) ?: array_push($_ventasF1F2, $venta);

        !callbackVentaUsuario($venta, $mail) ?: array_push($_ventasUsuario, $venta);

        strcmp($_GET['sabor'], $venta->_saborHelado) != 0 ?: array_push($_ventasSabor, $venta);
    }

    usort($_ventasF1F2, 'callbackSaboresFecha');

    /* Impresión de mensajes */
    echo "a- Cantidad de helados vendidos el " . $fechaConsulta->format('d-m-Y') . ": $_heladosVendidos\n";

    echo "--------------------------------\n";
    if (CheckVentasActivas($_ventasUsuario)) {
        echo "b- Listado de ventas activas del usuario " . $mail . ":\n";
        echo MostrarVentasActivas($_ventasUsuario);
    } else {
        echo "b- No existen ventas activas del usuario " . $mail . ".\n";
    }

    echo "--------------------------------\n";
    if (CheckVentasActivas($_ventasF1F2)) {
        echo "c- Ventas activas entre " . $fechaInicio->format('d-m-Y') . ' y ' . $fechaFinal->format('d-m-Y') . " ordenadas por sabor:\n";
        echo MostrarVentasActivas($_ventasF1F2);
    } else {
        echo "c- No existen ventas activas entre " . $fechaInicio->format('d-m-Y') . ' y ' . $fechaFinal->format('d-m-Y') . ".\n";
    }

    echo "--------------------------------\n";
    if (CheckVentasActivas($_ventasSabor)) {
        echo "d- Listado de ventas activas de Helado de " . $_GET['sabor'] . ":\n";
        echo MostrarVentasActivas($_ventasSabor);
    } else {
        echo "d- No existen ventas activas del sabor " . $_GET['sabor'] . ".\n";
    }
} else {
    echo "Revise los primeros dos valores ingresados!\n";
}

/* Funciones */
function callbackEntreDosFechas(DateTime $fechaAChequear, DateTime $fecha1, DateTime $fecha2)
{
    return $fechaAChequear >= $fecha1 && $fechaAChequear < date_add($fecha2, date_interval_create_from_date_string("1 day"));
}

function callbackVentaUsuario($venta, string $mailUsuario)
{
    $usuarioVenta = explode("@", $venta->_mailUsuario);
    $usuarioSolicitado = explode("@", $mailUsuario);

    return strcasecmp($usuarioVenta[0], $usuarioSolicitado[0]) == 0;
}

function callbackSaboresFecha($venta1, $venta2)
{
    return strcasecmp($venta1->_saborHelado, $venta2->_saborHelado);
}

function MostrarVentasActivas($ventas)
{
    $str = '';
    foreach ($ventas as $venta) {
        if ($venta->_activo) {
            $str .= "N° Pedido: $venta->_numeroPedido.\n";
            $str .= "ID: $venta->_id.\n";
            $str .= "Mail de usuario: $venta->_mailUsuario.\n";
            $str .= "Cantidad, sabor y tipo de Helado: $venta->_cantHelado $venta->_saborHelado $venta->_tipoHelado.\n";
            $str .= "Precio final de venta: $$venta->_precioFinal.\n";
            $str .= "Fecha de pedido: $venta->_fechaPedido.\n\n";
        }
    }

    return $str;
}

function CheckVentasActivas($ventas)
{
    foreach ($ventas as $venta) {
        if ($venta->_activo)
            return true;
    }

    return false;
}
