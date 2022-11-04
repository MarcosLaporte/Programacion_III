<?php
include_once "ManejoArchivos.php";

class Devolucion
{
    public int $_id;
    public string $_causa;
    public int $_numeroDePedido;
    public int $_idCupon;

    public function __construct(string $causa, int $numeroDePedido, int $idCupon)
    {
        $this->_id = count(LeerDatosJSON("devoluciones.json")) + 1;
        $this->_causa = $causa;
        $this->_numeroDePedido = $numeroDePedido;
        $this->_idCupon = $idCupon;
    }

    public static function BuscarDevolucion(array $devolucionesExistentes, $numeroPedido)
    {
        for ($i = 0; $i < count($devolucionesExistentes); $i++) {
            if ($devolucionesExistentes[$i]->_numeroDePedido == $numeroPedido) {
                return $i;
            }
        }

        return -1;
    }

    public static function GuardarImagenClienteEnojado($venta)
    {
        is_dir(getcwd() . '/ImagenesDeClientesEnojados') ?: mkdir(getcwd() . '/ImagenesDeClientesEnojados');
        $mailSeparado = explode("@", $venta->_mailUsuario);
        $archivo = $venta->_saborHelado . '_' . $venta->_tipoHelado . '_' .  $mailSeparado[0] . '_' . $venta->_fechaPedido;
        $destino = "ImagenesDeClientesEnojados/" . $archivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];

        return move_uploaded_file($tmpName, $destino);
    }
}
