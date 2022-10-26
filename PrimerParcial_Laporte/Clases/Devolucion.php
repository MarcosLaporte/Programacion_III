<?php

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
}
