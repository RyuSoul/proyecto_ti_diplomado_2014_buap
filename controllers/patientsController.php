<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 16/04/14
 * Time: 01:14 PM
 */
class patientsController extends Controller
{
    private $_user;
    private $_ajax;

    public function __construct()
    {
        parent::__construct();
        $this->_user = $this->loadModel('patients');
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index()
    {
        Session::accesoEstricto(array('usuario'));
        $this->_view->setJs(array('ajaxCiudades'));
        $this->_view->paises=$this->_ajax->getPaises();
        $this->_view->titulo = 'Nuevo Paciente';
        $this->_view->renderizar('newPatient');
    }

    public function searchPatient()
    {
        $this->_view->titulo = 'Editar Paciente';
        if ($this->getInt('enviar') == 1) {
            $idPaciente = $_POST['idPaciente'];
            $this->redireccionar('patients' . DS . 'editPatient' . DS . $idPaciente);
        }
        $this->_view->renderizar('searchPatient');
    }

    public function editPatient($valor)
    {
        echo $valor;
        $this->_view->titulo = 'Editar Paciente';
        $this->_view->renderizar('searchPatient');
    }

    public function savePatient()
    {
        $this->_view->titulo = 'Guardar';
        $this->_view->datos = $_POST;

        /*
         * Recuerda verificar el nombre del tag del input
         */

        /*if(isset($_FILES['file']['name'])){
            $this->getLibrary('upload' . DS . 'class.upload');
            $ruta = ROOT . 'public' . DS . 'img' . DS . 'patients' . DS;
            $upload = new upload($_FILES['file'], 'fr_FR');
            $upload->allowed = array('image/*');
            $upload->file_new_name_body = 'upl_' . uniqid();
            $upload->process($ruta);
        }


        //Crear una instancia de PHPMailer
        /*$this->getLibrary('phpmailer'.DS.'mail');
        $correo=new Mail();
        $correo->sendMail();*/


    }

    public function deletePatient()
    {
        $this->_view->titulo = 'borrar';
        $this->_view->renderizar('deletePatient');
    }
}