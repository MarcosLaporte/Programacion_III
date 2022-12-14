<?php
include_once "ManejoArchivos.php";

class Helado{
    public int $_id;
    public string $_sabor;
    public float $_precio;
    public string $_tipo;
    public int $_stock;

    #region Setters
    public function setID(){
        $this->_id = count(LeerDatosJSON("heladeria.json"))+1;
    }
    public function setSabor(string $sabor){
        $s = str_replace(' ', '-', $sabor);
        $this->_sabor = empty(trim($s)) ? "chocolate" : strtolower($s);
    }
    public function setPrecio(float $precio){
        $precio <= 0 ? $this->_precio = 250 : $this->_precio = $precio;
    }
    public function setTipo(string $tipo){
        $tipoLwr = empty(trim($tipo)) ? "-" : strtolower($tipo);
        if($tipoLwr == "agua" || $tipoLwr == "crema"){
            $this->_tipo = $tipoLwr;
        }else{
            random_int(0,1) == 0 ? $this->_tipo = "agua" : $this->_tipo = "crema";
        }
    }
    public function setStock(int $stock){
        $stock <= 0 ? $this->_stock = 1 : $this->_stock = $stock;
    }
    #endregion

    public function __construct(string $sabor = 'chocolate', float $precio, string $tipo, int $stock){
        $this->setID();
        $this->setSabor($sabor);
        $this->setPrecio($precio);
        $this->setTipo($tipo);
        $this->setStock($stock);
    }

    public function Equals($helado){
        return !strcasecmp($this->_sabor, $helado->_sabor) && !strcasecmp($this->_tipo, $helado->_tipo);
    }

    public static function BuscarHelado(array $heladosExistentes, Helado $helado){
        for($i = 0; $i < count($heladosExistentes); $i++){
            if($helado->Equals($heladosExistentes[$i])){
                return $i;
            }
        }

        return -1;
    }
    
    public function GuardarImagenHelado(){
        is_dir(getcwd() . '/ImagenesDeHelados') ? : mkdir(getcwd() . '/ImagenesDeHelados');
        $archivo = $this->_sabor . '_' . $this->_tipo;
        $destino = "ImagenesDeHelados/" . $archivo . ".jpg";
        $tmpName = $_FILES["imagen"]["tmp_name"];
        $ret = false;

        if (move_uploaded_file($tmpName, $destino)) {
            echo "La imagen se guard?? correctamente.\n";
            $ret = true;
        }else{
            echo "La imagen no pudo guardarse.\n";
        }

        return $ret;
    }
}

