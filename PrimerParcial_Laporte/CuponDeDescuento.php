<?php

class CuponDeDescuento
{
    public int $_id;
    public int $_devolucionId;
    public string $_causa;
    public int $_porcentajeDescuento;
    public string $_estado;

    public function __construct(string $causa)
    {
        $this->_id = count(LeerDatosJSON("cupones.json")) + 1;
        $this->_devolucionId = CuponDeDescuento::NuevoIdDescuento(LeerDatosJSON("cupones.json"));
        $this->_causa = empty(trim($causa)) ? 'Distintos sabores' : $causa;
        $this->_porcentajeDescuento = 10;
        $this->_estado = "no usado";
    }

    private static function NuevoIdDescuento(array $arrayCupones)
    {
        $numero = random_int(1000, 9999);
        do {
            $existe = false;
            foreach ($arrayCupones as $cupon) {
                if ($numero == $cupon->_devolucionId) {
                    $numero = random_int(1000, 9999);
                    $existe = true;
                    break;
                }
            }
        } while ($existe);

        return $numero;
    }

    public static function GuardarImagenClienteEnojado($venta)
    {
        is_dir(getcwd() . '/ImagenesDeClientesEnojados') ?: mkdir(getcwd() . '/ImagenesDeClientesEnojados');
        $mailSeparado = explode("@", $venta->_mailUsuario);
        $archivo = $venta->_saborHelado . '_' . $venta->_tipoHelado . '_' .  $mailSeparado[0] . '_' . $venta->_fechaPedido;
        $destino = "ImagenesDeClientesEnojados/" . $archivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        $ret = false;

        if (move_uploaded_file($tmpName, $destino)) {
            $ret = true;
        }

        return $ret;
    }

    public function MostrarCupon()
    {
        return "Cupón N°" . $this->_devolucionId . " por un " .
            $this->_porcentajeDescuento ."% de descuento.\nNotas: " . $this->_causa . "\n";
    }
}
