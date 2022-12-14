<?php
/* Laporte Marcos */

include_once "ManejoArchivos.php";

class Venta
{
    public int $_numeroPedido;
    public int $_id;
    public string $_mailUsuario;
    public string $_saborHelado;
    public string $_tipoHelado;
    public int $_cantHelado;
    public string $_fechaPedido;
    public float $_precioFinal;
    public bool $_activo;

    #region Setter
    public function setNumeroPedido()
    {
        $this->_numeroPedido = Venta::NuevoNumPedido(LeerDatosJSON("Ventas.json"));
    }
    public function setID()
    {
        $this->_id = count(LeerDatosJSON("Ventas.json")) + 1;
    }
    public function setMail(string $mail)
    {
        $auxMail = strtolower($mail);
        $this->_mailUsuario = Venta::MailValido($auxMail) ? $auxMail : 'invalid_email';
    }
    public function setSabor(string $sabor)
    {
        $this->_saborHelado = strtolower($sabor);
    }
    public function setTipo(string $tipo)
    {
        $tipoLwr = strtolower($tipo);
        if ($tipoLwr == "agua" || $tipoLwr == "crema") {
            $this->_tipoHelado = $tipoLwr;
        } else {
            $this->_tipo = random_int(0, 1) == 0 ? "agua" : "crema";
        }
    }
    public function setCantidad(int $cant)
    {
        $this->_cantHelado = $cant <= 0 ? 1 : $cant;
    }
    public function setFecha(string $strFecha)
    {
        $fecha = DateTime::createFromFormat('d-m-Y', $strFecha) ?: new DateTime('now');
        $auxFecha = $fecha <= new DateTime('now') ? $fecha : new DateTime('now');

        $this->_fechaPedido = $auxFecha->format('d-m-Y');
    }
    public function setPrecioFinal(float $precio){
        $this->_precioFinal = $precio <= 0 ? 1 : $precio;
    }
    #endregion

    public function __construct($mailUsuario = 'defaultmail@utnfra.com', $saborHelado = 'chocolate', $tipoHelado, $cantHelado, string $fechaPedido = new DateTime('now'), float $precioFinal)
    {
        $this->setNumeroPedido();
        $this->setID();
        $this->setMail($mailUsuario);
        $this->setSabor($saborHelado);
        $this->setTipo($tipoHelado);
        $this->setCantidad($cantHelado);
        $this->setFecha($fechaPedido);
        $this->setPrecioFinal($precioFinal);
        $this->_activo = true;
    }

    public static function MailValido(string $mail)
    {
        $arrobaCont = 0;
        $puntoCont = 0;
        $letraCont = 0;

        for ($i = 0; $i < strlen($mail); $i++) {
            if ($mail[$i] == '@') {
                $arrobaCont++;
                if ($arrobaCont > 1) return false;
            } else if ($mail[$i] == '.') {
                $puntoCont++;
                if ($puntoCont > 1) return false;
            } else if (ctype_alnum($mail[$i])) {
                $letraCont++;
            }
        }
        return ($arrobaCont == 1 && $puntoCont == 1 && $letraCont >= 3); //Al menos 3 letras (a@a.a)
    }

    public static function NuevoNumPedido(array $arrayVentas)
    {
        $numero = random_int(1000, 9999);
        do {
            $existe = false;
            foreach ($arrayVentas as $venta) {
                if ($numero == $venta->_numeroPedido) {
                    $numero = random_int(1000, 9999);
                    $existe = true;
                    break;
                }
            }
        } while ($existe);

        return $numero;
    }

    public function GuardarImagenVenta()
    {
        is_dir(getcwd() . '/ImagenesDeLaVenta') ?: mkdir(getcwd() . '/ImagenesDeLaVenta');
        $mailSeparado = explode("@", $this->_mailUsuario);
        $archivo = $this->_saborHelado . '_' . $this->_tipoHelado . '_' .  $mailSeparado[0] . '_' . $this->_fechaPedido;
        $destino = "ImagenesDeLaVenta/" . $archivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        $ret = false;

        if (move_uploaded_file($tmpName, $destino)) {
            echo "La foto se guard?? correctamente.\n";
            $ret = true;
        } else {
            echo "La foto no pudo guardarse.\n";
        }

        return $ret;
    }

    public static function BuscarVenta(array $ventasExistentes, $numeroPedido)
    {
        for ($i = 0; $i < count($ventasExistentes); $i++) {
            if ($ventasExistentes[$i]->_numeroPedido == $numeroPedido) {
                return $i;
            }
        }

        return -1;
    }
}
