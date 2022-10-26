<?php
/* borrarVenta.php(por DELETE), debe recibir un número de pedido, 
se borra la venta(soft-delete, no físicamente) y la foto relacionada
a esa venta debe moverse a la carpeta /ImagenesBackupVentas

Laporte Marcos */

include_once "Clases\\Venta.php";
include_once "Clases\\Helado.php";

$arrayVentas = BorrarVenta(LeerDatosJSON("Ventas.json"));
GuardarDatosJSON($arrayVentas, "Ventas.json");

function BorrarVenta(array $arrayVentas){
    $auxVentas = $arrayVentas;
    parse_str(file_get_contents("php://input"), $datos);
    $numPedido = empty($datos['numeroDePedido']) ? 0 : $datos['numeroDePedido'];
    
    $indexVenta = Venta::BuscarVenta($auxVentas, $numPedido);
    if($indexVenta != -1 && $auxVentas[$indexVenta]->_activo){
        $nombreArchivo = $auxVentas[$indexVenta]->_saborHelado.'_'.$auxVentas[$indexVenta]->_tipoHelado.'_'.explode("@", $auxVentas[$indexVenta]->_mailUsuario)[0].'_'.$auxVentas[$indexVenta]->_fechaPedido.'.jpg';
        $fotoDirViejo = 'ImagenesDeLaVenta\\';
        $fotoDirNuevo = 'ImagenesBackupVentas\\';

        is_dir($fotoDirNuevo) ? : mkdir($fotoDirNuevo);

        if (copy($fotoDirViejo.$nombreArchivo, $fotoDirNuevo.$nombreArchivo)) {
            unlink($fotoDirViejo.$nombreArchivo);
            echo "La foto se movió correctamente.\n";
        }else{
            echo "La foto no pudo moverse.\n";
        }

        $auxVentas[$indexVenta]->_activo = false;
    }else{
        echo "No existe una venta activa con número de pedido N°$numPedido.\n";
        echo "Los disponibles son:\n";
        foreach ($arrayVentas as $venta) {
            if($venta->_activo)
                echo '~ ' . $venta->_numeroPedido . "\n";
        }
    }

    return $auxVentas;
}

?>