<?php
/* ModificarVenta.php (por PUT)
Debe recibir el número de pedido, el email del usuario, el nombre, tipo y stock, si existe se modifica , de lo
contrario informar que no existe ese número de pedido.

Laporte Marcos */

include_once "Venta.php";
include_once "Helado.php";

$arrayVentas = ModVenta(LeerDatosJSON("ventas.json"), LeerDatosJSON("heladeria.json"));
GuardarDatosJSON($arrayVentas, "ventas.json");


function ModVenta(array $arrayVentas, array $arrayHelados){
    parse_str(file_get_contents("php://input"), $datos);
    $auxVentas = $arrayVentas;
    $auxHelados = $arrayHelados;
    
    $indexVenta = Venta::BuscarVenta($arrayVentas, $datos['numeroDePedido']);
    if($indexVenta != -1){
        $fotoNombreViejo = getcwd().'\\ImagenesDeLaVenta\\'.$auxVentas[$indexVenta]->_saborHelado.'_'.$auxVentas[$indexVenta]->_tipoHelado.'_'.explode("@", $auxVentas[$indexVenta]->_mailUsuario)[0].'_'.$auxVentas[$indexVenta]->_fechaPedido.'.jpg';
        $auxVentas[$indexVenta]->_mailUsuario = ModMail($auxVentas[$indexVenta], $datos['mail']);
        
        if(!empty($datos['sabor']) && !empty($datos['tipo'])){
            $auxHelado = new Helado($datos['sabor'], 0, $datos['tipo'], 0);
        }else{
            $auxHelado = $auxVentas[$indexVenta];
        }
        
        $indexHelado = Helado::BuscarHelado($auxHelados, $auxHelado);
        
        if($indexHelado != -1){
            $fotoNombreNuevo = getcwd().'\\ImagenesDeLaVenta\\'.$datos['sabor'].'_'.$datos['tipo'].'_'.explode("@", $auxVentas[$indexVenta]->_mailUsuario)[0].'_'.$auxVentas[$indexVenta]->_fechaPedido.'.jpg';
            
            $auxVentas[$indexVenta]->_saborHelado = $datos['sabor'];
            $auxVentas[$indexVenta]->_tipoHelado = $datos['tipo'];
            
            if($auxVentas[$indexVenta]->_stockHelado != $datos['cantidad']){
                $stockActualizado = $auxHelados[$indexHelado]->_stock + $auxVentas[$indexVenta]->_stockHelado - $datos['cantidad'];
                if($stockActualizado > 0){
                    $auxHelados[$indexHelado]->_stock = $stockActualizado;
                    $auxVentas[$indexVenta]->_stockHelado = $datos['cantidad'];
                    echo "La cantidad del pedido ha sido actualizada a " . $datos['cantidad'] . ".\n";
                }else{
                    echo "No alcanzan los helados. Seguiremos con la cantidad original.\n";
                }
            }
            GuardarDatosJSON($auxHelados, "heladeria.json");
            echo "La venta N°" . $datos['numeroDePedido'] . " fue modificada!\n";
        }else{
            echo "No contamos con ese helado específico.";
        }

        rename($fotoNombreViejo, $fotoNombreNuevo);

    }else{
        echo "No existe una venta con número de pedido N°" . $datos['numeroDePedido'] . ".\n";
        echo "Los disponibles son:\n";
        foreach($arrayVentas as $ventas){
            echo '~ ' . $ventas->_numeroPedido . "\n";
        }
    }

    return $auxVentas;
}

function ModMail($venta, string $mail){
    $auxMail = strtolower($mail);
    return Venta::MailValido($auxMail) ? $auxMail : $venta->_mailUsuario;
}