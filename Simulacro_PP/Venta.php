<?php
/* Laporte Marcos */

include_once "ManejoArchivos.php";

class Venta{
    public int $_numeroPedido;
    public int $_id;
    public string $_mailUsuario;
    public string $_saborPizza;
    public string $_tipoPizza;
    public int $_cantidadPizza;
    public string $_fechaPedido;

    #region Setter
    public function setNumeroPedido(){
        $this->_numeroPedido = Venta::NuevoNumPedido(LeerDatos("Ventas.json"));
    }
    public function setID(){
        $this->_id = count(LeerDatos("Ventas.json"))+1;
    }
    public function setMail(string $mail){
        $auxMail = strtolower($mail);
        $this->_mailUsuario = Venta::MailValido($auxMail) ? $auxMail : 'invalid_email';
    }
    public function setSabor(string $sabor){
        $this->_saborPizza = strtolower($sabor);
    }
    public function setTipo(string $tipo){
        $tipoLwr = strtolower($tipo);
        if($tipoLwr == "molde" || $tipoLwr == "piedra"){
            $this->_tipoPizza = $tipoLwr;
        }else{
            random_int(0,1) == 0 ? $this->_tipo = "molde" : $this->_tipo = "piedra";
        }
    }
    public function setCantidad(int $cantidad){
        $cantidad <= 0 ? $this->_cantidadPizza = 1 : $this->_cantidadPizza = $cantidad;
    }
    public function setFecha(string $strFecha){
        $fecha = DateTime::createFromFormat('d-m-Y', $strFecha) ? : new DateTime('now');
        $auxFecha = $fecha <= new DateTime('now') ? $fecha : new DateTime('now');

        $this->_fechaPedido = $auxFecha->format('d-m-Y');
    }
    #endregion

    public function __construct($mailUsuario = 'michelangelo@tmnt.com', $saborPizza = 'muzza', $tipoPizza, $cantidadPizza, string $fechaPedido = new DateTime('now')){
        $this->setNumeroPedido();
        $this->setID();
        $this->setMail($mailUsuario);
        $this->setSabor($saborPizza);
        $this->setTipo($tipoPizza);
        $this->setCantidad($cantidadPizza);
        $this->setFecha($fechaPedido);
    }

    public static function MailValido(string $mail){
        $arrobaCont = 0;
        $puntoCont = 0;
        $letraCont = 0;

        for($i = 0; $i < strlen($mail); $i++){
            if($mail[$i] == '@'){
                $arrobaCont++;
                if($arrobaCont > 1) return false;
            }else if($mail[$i] == '.'){
                $puntoCont++;
                if($puntoCont > 1) return false;
            }else if(ctype_alnum($mail[$i])){
                $letraCont++;
            }
        }
        return ($arrobaCont == 1 && $puntoCont == 1 && $letraCont >= 3); //Al menos 3 letras (a@a.a)
    }

    public static function NuevoNumPedido(array $arrayVentas){
        $numero = random_int(1000, 9999);
        do{
            $existe = false;
            foreach($arrayVentas as $venta){
                if($numero == $venta->_numeroPedido){
                    $numero = random_int(1000, 9999);
                    $existe = true;
                    break;
                }
            }
        }while($existe);

        return $numero;
    }
}



?>