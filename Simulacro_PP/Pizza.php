<?php
/* Laporte Marcos */

class Pizza{
    public int $_id;
    public string $_sabor;
    public float $_precio;
    public string $_tipo;
    public int $_cantidad;
    
    #region Setters
    public function setID(){
        $this->_id = count(Pizza::LeerDatos())+1;
    }
    public function setSabor($sabor){
        $this->_sabor = strtolower($sabor);
    }
    public function setPrecio($precio){
        $precio <= 0 ? $this->_precio = 250 : $this->_precio = $precio;
    }
    public function setTipo($tipo){
        $tipoLwr = strtolower($tipo);
        if($tipoLwr == "molde" || $tipoLwr == "piedra"){
            $this->_tipo = $tipoLwr;
        }else{
            random_int(0,1) == 0 ? $this->_tipo = "molde" : $this->_tipo = "piedra";
        }
    }
    public function setCantidad($cantidad){
        $cantidad <= 0 ? $this->_cantidad = 1 : $this->_cantidad = $cantidad;
    }
    #endregion

    public function __construct($sabor, $precio, $tipo, $cantidad){
        $this->setID();
        $this->setSabor($sabor);
        $this->setPrecio($precio);
        $this->setTipo($tipo);
        $this->setCantidad($cantidad);
    }

    public static function LeerDatos(){
        $refArchivo = fopen("Pizza.json", "a+");
        
        if($refArchivo){
            $textoArchivo = fgets($refArchivo);
            json_decode($textoArchivo, false) != null ? $decode = json_decode($textoArchivo, false) : $decode = array();
        }
        fclose($refArchivo);
        
        return $decode;
    }

    /* public function MostrarPizza() {
        return $this->_cantidad . ' pizza/s sabor ' . $this->_sabor . ' tipo ' . $this->_tipo . ' por $' . $this->_precio . "\n";
    } */
    
    public function Equals($pizza){
        return !strcasecmp($this->_tipo, $pizza->_tipo) && !strcasecmp($this->_sabor, $pizza->_sabor);
    }
}
?>