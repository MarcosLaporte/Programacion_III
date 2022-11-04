<?php
/* ModificarVenta.php (por PUT)
Debe recibir el número de pedido, el email del usuario, el nombre, tipo y stock, si existe se modifica , de lo
contrario informar que no existe ese número de pedido.

Laporte Marcos */

include_once "Clases\\Venta.php";
include_once "Clases\\Helado.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayHelados = LeerDatosJSON("heladeria.json");
$_arrayVentas = ModVenta($_arrayVentas, $_arrayHelados);
GuardarDatosJSON($_arrayVentas, "ventas.json");

function ModVenta(array $arrayVentas, array $arrayHelados)
{
    parse_str(file_get_contents("php://input"), $datos);
    $auxVentas = $arrayVentas;
    $auxHelados = $arrayHelados;
    $numPedido = empty($datos['numeroDePedido']) ? 0 : $datos['numeroDePedido'];

    $indexVenta = Venta::BuscarVenta($arrayVentas, $numPedido);
    if ($indexVenta != -1) {
        $venta = $auxVentas[$indexVenta];

        $usuarioViejo = explode("@", $venta->_mailUsuario)[0];

        $fotoNombreViejo = getcwd() . '\\ImagenesDeLaVenta\\' . $venta->_saborHelado .
            '_' . $venta->_tipoHelado . '_' . $usuarioViejo . '_' . $venta->_fechaPedido . '.jpg';

        #region Verifico los datos ingresados
        if (Venta::MailValido($datos['mail'])) {
            $mail = $datos['mail'];
            $auxVentas[$indexVenta]->_mailUsuario = $mail;
        } else {
            $mail = $venta->_mailUsuario;
            echo "El mail indicado no es válido. Se utilizará el original.\n";
        }
        $usuarioNuevo = explode("@", $mail)[0];

        if (!empty($datos['sabor'])) {
            $sabor = $datos['sabor'];
        } else {
            $sabor = $venta->_saborHelado;
            echo "El sabor indicado no es válido. Se utilizará el original.\n";
        }

        if (!empty($datos['tipo'])) {
            $tipo = $datos['tipo'];
        } else {
            $tipo = $venta->_tipoHelado;
            echo "El tipo indicado no es válido. Se utilizará el original.\n";
        }

        if ((int)$datos['cantidad'] >= 0) {
            $cantidad = (int)$datos['cantidad'];
        } else {
            $cantidad = 0;
        }
        #endregion

        $indexHelado = Helado::BuscarHelado($auxHelados, new Helado($sabor, 1, $tipo, $cantidad));

        if ($indexHelado != -1) {
            $fotoNombreNuevo = getcwd() . '\\ImagenesDeLaVenta\\' . $sabor . '_' . $tipo . '_' . $usuarioNuevo . '_' . $venta->_fechaPedido . '.jpg';

            $auxVentas[$indexVenta]->_saborHelado = $sabor;
            $auxVentas[$indexVenta]->_tipoHelado = $tipo;

            if ($cantidad != $venta->_cantHelado) {
                $stockActualizado = $auxHelados[$indexHelado]->_stock + $venta->_cantHelado - $cantidad;
                if ($stockActualizado >= 0) {
                    $auxHelados[$indexHelado]->_stock = $stockActualizado;
                    $auxVentas[$indexVenta]->_cantHelado = $cantidad;
                    $nuevoPrecio = $cantidad * $auxHelados[$indexHelado]->_precio;
                    $auxVentas[$indexVenta]->_precioFinal = $nuevoPrecio;
                    echo "La cantidad del pedido ha sido actualizada a $cantidad y el precio final a $nuevoPrecio.\n";
                } else {
                    echo "No alcanzan los helados. Seguiremos con la cantidad original.\n";
                }
            }
            echo "La venta N°$numPedido fue modificada!\n";
            GuardarDatosJSON($auxHelados, "heladeria.json");

            if(strcasecmp($fotoNombreViejo, $fotoNombreNuevo) != 0){
                rename($fotoNombreViejo, $fotoNombreNuevo);
            }
        } else {
            echo "No contamos con helado de $sabor de $tipo.";
        }

    } else {
        echo "No existe una venta activa con número de pedido N°$numPedido.\n";
        echo "Los disponibles son:\n";
        foreach ($arrayVentas as $venta) {
            if($venta->_activo)
                echo '~ ' . $venta->_numeroPedido . "\n";
        }
    }

    return $auxVentas;
}

