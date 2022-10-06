<?php
/*
Recibe los datos del usuario(nombre, clave, mail) por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv. retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario

Ejercicio 20 BIS

Laporte Marcos
*/

class Usuario{
    private string $_nombre;
    private string $_clave;
    private string $_mail;


    public function __construct(string $nombre, string $clave, string $mail){
        $this->_nombre = $nombre;
        $this->_clave = $clave;
        $this->_mail = $mail;
    }

    public function getNombre(){
        return $this->_nombre;
    }
    public function getClave(){
        return $this->_clave;
    }
    public function getMail(){
        return $this->_mail;
    }

    public static function DatosInvalidos(Usuario $usuario){
        return empty($usuario->_nombre) || empty($usuario->_clave) || empty($usuario->_mail);
    }

    public static function AltaUsuario(Usuario $usuario){
        $refArchivo = fopen("usuarios.csv", "a");
        $ret = false;

        if($refArchivo && !Usuario::DatosInvalidos($usuario)){
            fwrite($refArchivo, "User: $usuario->_nombre, Clave: $usuario->_clave, Mail: $usuario->_mail\n");
            $ret = true;
        }
        
        fclose($refArchivo);

        return $ret;
    }

    public static function LeerUsuarios(){
        $refArchivo = fopen("usuarios.csv", "r");
        $datos = array();
        $usuarios = array();

        while(!feof($refArchivo)){
            $datos = fgetcsv($refArchivo);
            if(!empty($datos)){
                array_push($usuarios, new Usuario($datos[0], $datos[1], $datos[2]));
            }
        }

        fclose($refArchivo);
        
        return $usuarios;
    }
}

?>