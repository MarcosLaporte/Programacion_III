<?php
include_once "ManejoArchivos.php";

class CuponDeDescuento
{
    public int $_id;
    public int $_devolucionId;
    public string $_causa;
    public int $_porcentajeDescuento;
    public string $_estado;

    public function __construct(int $devolucionId, string $causa)
    {
        $this->_id = CuponDeDescuento::NuevoId(LeerDatosJSON('cupones.json'));
        $this->_devolucionId = $devolucionId;
        $this->_causa = empty(trim($causa)) ? 'Distintos sabores' : $causa;
        $this->_porcentajeDescuento = 10;
        $this->_estado = "no usado";
    }

    public static function NuevoId(array $arrayCupones)
    {
        $numero = random_int(1000, 9999);
        do {
            $existe = false;
            foreach ($arrayCupones as $cupon) {
                if ($numero == $cupon->_id) {
                    $numero = random_int(1000, 9999);
                    $existe = true;
                    break;
                }
            }
        } while ($existe);

        return $numero;
    }

    public static function BuscarCuponActivo(array $cuponesExistentes, int $idCupon)
    {
        for ($i = 0; $i < count($cuponesExistentes); $i++) {
            if ($idCupon == $cuponesExistentes[$i]->_id &&
                !strcasecmp($cuponesExistentes[$i]->_estado, "no usado")) {
                return $i;
            }
        }

        return -1;
    }
}
