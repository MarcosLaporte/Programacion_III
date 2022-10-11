<?php
/* Laporte Marcos */

include_once "ManejoArchivos.php";

class Pizza{
    public int $_id;
    public string $_sabor;
    public float $_precio;
    public string $_tipo;
    public int $_cantidad;
    
    #region Setters
    public function setID(){
        $this->_id = count(LeerDatosJSON("Pizza.json"))+1;
    }
    public function setSabor(string $sabor){
        $this->_sabor = strtolower($sabor);
    }
    public function setPrecio(float $precio){
        $precio <= 0 ? $this->_precio = 250 : $this->_precio = $precio;
    }
    public function setTipo(string $tipo){
        $tipoLwr = strtolower($tipo);
        if($tipoLwr == "molde" || $tipoLwr == "piedra"){
            $this->_tipo = $tipoLwr;
        }else{
            random_int(0,1) == 0 ? $this->_tipo = "molde" : $this->_tipo = "piedra";
        }
    }
    public function setCantidad(int $cantidad){
        $cantidad < 0 ? $this->_cantidad = 0 : $this->_cantidad = $cantidad;
    }
    #endregion

    public function __construct(string $sabor = 'muzza', float $precio, string $tipo, int $cantidad){
        $this->setID();
        $this->setSabor($sabor);
        $this->setPrecio($precio);
        $this->setTipo($tipo);
        $this->setCantidad($cantidad);
    }

    public function Equals($pizza){
        return !strcasecmp($this->_tipo, $pizza->_tipo) && !strcasecmp($this->_sabor, $pizza->_sabor);
    }

    public static function BuscarPizza(array $pizzasExistentes, Pizza $pizza){
        $ret = -1;
        foreach($pizzasExistentes as $pizzaE){
            if($pizza->Equals($pizzaE)){
                $ret = array_search($pizzaE, $pizzasExistentes);
                break;
            }
        }

        return $ret;
    }
    
    public function GuardarImagenPizza(){
        is_dir(getcwd() . '/ImagenesDePizzas') ? : mkdir(getcwd() . '/ImagenesDePizzas');
        $archivo = $this->_tipo . '_' . $this->_sabor;
        $destino = "ImagenesDePizzas/" . $archivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        $ret = false;

        if (move_uploaded_file($tmpName, $destino)) {
            echo "La foto se guardó correctamente.\n";
            $ret = true;
        }else{
            echo "La foto no pudo guardarse.\n";
        }

        return $ret;
    }
}
?>