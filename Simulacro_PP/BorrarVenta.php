<?php
/* borrarVenta.php(por DELETE), debe recibir un número de pedido, 
se borra la venta y la foto se mueve a la carpeta /BACKUPVENTAS

Laporte Marcos */

include_once "Venta.php";
include_once "Pizza.php";

$arrayVentas = BorrarVenta(LeerDatosJSON("Ventas.json"));
GuardarDatosJSON($arrayVentas, "Ventas.json");

function BorrarVenta(array $arrayVentas){
    $auxVentas = $arrayVentas;
    parse_str(file_get_contents("php://input"), $datos);
    
    $indexVenta = Venta::BuscarVenta($auxVentas, $datos['numeroDePedido']);
    if($indexVenta != -1){
        $nombreArchivo = $auxVentas[$indexVenta]->_tipoPizza.'_'.$auxVentas[$indexVenta]->_saborPizza.'_'.explode("@", $auxVentas[$indexVenta]->_mailUsuario)[0].'_'.$auxVentas[$indexVenta]->_fechaPedido.'.jpg';
        $fotoDirViejo = 'ImagenesDeLaVenta\\';
        $fotoDirNuevo = 'BACKUPVENTAS\\';

        is_dir($fotoDirNuevo) ? : mkdir($fotoDirNuevo);

        if (copy($fotoDirViejo.$nombreArchivo, $fotoDirNuevo.$nombreArchivo)) {
            unlink($fotoDirViejo.$nombreArchivo);
            echo "La foto se guardó correctamente.\n";
        }else{
            echo "La foto no pudo guardarse.\n";
        }

        unset($auxVentas[$indexVenta]);
    }

    return $auxVentas;
}

?>