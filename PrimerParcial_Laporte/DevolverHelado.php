<?php
/* 6-
Guardar en el archivo (devoluciones.json y cupones.json):
a- Se ingresa el número de pedido y la causa de la devolución. El número de pedido debe existir, se ingresa una
foto del cliente enojado,esto debe generar un cupón de descuento(id, devolucion_id, porcentajeDescuento,
estado[usado/no usadol]) con el 10% de descuento para la próxima compra.

Laporte Marcos*/

include_once "Venta.php";
include_once "CuponDeDescuento.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayCupones = LeerDatosJSON("cupones.json");

$indexVenta = Venta::BuscarVenta($_arrayVentas, $_POST['numeroDePedido']);

if($indexVenta != -1){
    CuponDeDescuento::GuardarImagenClienteEnojado($_arrayVentas[$indexVenta]);
    echo "Queja anotada! Tome un cupón de descuento para su próxima compra:\n";
    $cupon = new CuponDeDescuento();
    array_push($_arrayCupones, $cupon);
    GuardarDatosJSON($_arrayCupones, "cupones.json");
    echo $cupon->MostrarCupon();
}else{
    echo "No nos quiera cagar! Ese pedido no existe!\n";
}