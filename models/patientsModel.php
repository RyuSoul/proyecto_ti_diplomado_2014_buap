<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 16/04/14
 * Time: 04:21 PM
 */
class patientsModel extends Model
{
    protected $_nombre;
    public function __construct($nombre)
    {
        parent::__construct();
        $this->_nombre=$nombre;
    }

    public function getUsers()
    {
        $usuarios = $this->_db->select('usuario');

        return $usuarios;

    }

    public function getName(){
        return $this->_nombre;
    }

    public function addUser($nombre){
        echo "agregar";
    }
}