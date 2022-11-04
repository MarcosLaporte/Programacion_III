<?php
/* AltaVenta.php: (por POST) se recibe el email del usuario y el Sabor, Tipo y Stock, si el ítem existe en
heladeria.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) .
Se debe descontar la stock vendida del stock

Laporte Marcos*/

include_once "Clases\\Helado.php";
include_once "Clases\\Venta.php";
include_once "Clases\\CuponDeDescuento.php";

$_arrayHelados = LeerDatosJSON("heladeria.json");
$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayCupones = LeerDatosJSON("cupones.json");

$_arrayVentas = AddVenta($_arrayHelados, $_arrayVentas, $_arrayCupones);
GuardarDatosJSON($_arrayVentas, "ventas.json");

function AddVenta(array $arrayHelados, array $arrayVentas, array $arrayCupones)
{
    $heladoPedido = new Helado($_POST['sabor'], 0, $_POST['tipo'], 0);
    $cantidad = (int)$_POST['cantidad'];

    $auxHelados = $arrayHelados;
    $auxVentas = $arrayVentas;
    $indexHelado = Helado::BuscarHelado($auxHelados, $heladoPedido);
    $nuevoStock = 0;

    /* AltaVenta.php, …( continuación de 1ra parte, punto 3) Todo lo anterior más…
    a- Debe recibir el cupón de descuento (si existe) y guardar el importe final y el descuento aplicado en el archivo. */
    $auxCupones = $arrayCupones;
    $idCupon = empty($_POST['cupon']) ? 0 : (int)$_POST['cupon'];
    $indexCupon = CuponDeDescuento::BuscarCuponActivo($arrayCupones, $idCupon);


    if ($indexHelado != -1) {
        $helado = $auxHelados[$indexHelado];
        if ($helado->_stock > 0) {
            if ($helado->_stock - $cantidad > 0) {
                $nuevoStock = (int)$helado->_stock - $cantidad;
            } else {
                $cantidad = (int)$helado->_stock;
                echo "Cargaremos solo " . $helado->_stock . " unidades, ya que es lo que tenemos de ese helado.\n";
            }

            $precioInicial = (float)$cantidad * $helado->_precio;
            if ($indexCupon != -1) {
                $descuento = (int)$arrayCupones[$indexCupon]->_porcentajeDescuento;
                $precioFinal = $precioInicial - $precioInicial * $descuento / 100;
                /*b- Debe  marcarse el cupón como ya usado. */
                $auxCupones[$indexCupon]->_estado = "usado";
                echo "Se aplicó un $descuento% de descuento en su compra!\n";
                GuardarDatosJSON($auxCupones, "cupones.json");
            } else {
                $precioFinal = $precioInicial;
                if ($idCupon != 0) //Si es 0, el usuario no ingresó nada
                    echo "Su cupón no es válido.\n";
            }

            $venta = new Venta($_POST['mail'], $heladoPedido->_sabor, $heladoPedido->_tipo, $cantidad, $_POST['fechaPedido'], $precioFinal);
            array_push($auxVentas, $venta);
            $venta->GuardarImagenVenta();

            $auxHelados[$indexHelado]->_stock = $nuevoStock;
            GuardarDatosJSON($auxHelados, "heladeria.json");
            echo "Se realizó el pedido!\n";
        } else {
            echo "No hay stock.\n";
        }
    } else {
        echo "No existe tal helado.\n";
    }

    return $auxVentas;
}
