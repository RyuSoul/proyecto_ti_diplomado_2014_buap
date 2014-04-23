<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 17/04/14
 * Time: 04:22 PM
 */
class loginModel extends Model{

    public function __construct(){
        parent::__construct();

    }

    public function getUsuario($usuario,$password){
        $bind=array(":usuario"=>$usuario,":password"=>$password);
        $datos=$this->_db->select('usuarios','usuario=:usuario AND password=:password',$bind);
        return $datos[0];
    }
}