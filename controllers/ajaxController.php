<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 19/04/14
 * Time: 01:00 PM
 */
class ajaxController extends Controller
{
    private $_ajax;

    public function __construct() {
        parent::__construct();
        $this->_ajax = $this->loadModel('ajax');

    }

    public function index()
    {

    }

    public function getEstadosList()
    {

        if($this->getInt('pais')){
            echo json_encode($this->_ajax->getEstados($this->getInt('pais')));
        }
    }

    public function getMunicipiosList()
    {
        if($this->getInt('estado')){
            echo json_encode($this->_ajax->getMunicipios($this->getInt('estado')));
        }
    }

    public function getLocalidadesList(){
        if($this->getInt('municipio')){
            echo json_encode($this->_ajax->getLocalidades($this->getInt('municipio')));
        }
    }

    public function getCodigoPostal(){
        echo json_encode($this->_ajax->getCP($this->getInt('localidad')));
    }
}