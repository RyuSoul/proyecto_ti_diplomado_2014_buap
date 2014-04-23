<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 17/04/14
 * Time: 01:22 PM
 */

class loginController extends Controller
{

    private $_login;

    public function __construct()
    {
        parent::__construct();
        $this->_login = $this->loadModel('login');
    }

    public function index()
    {
        $this->_view->titulo = 'Iniciar Sesion';
        $this->_view->setJs(array('sha512', 'forms'));

        if ($this->getInt('enviar') == 1) {
            $this->_view->datos = $_POST;
            $row = $this->_login->getUsuario($this->getAlphaNum('user'), trim($this->_view->datos['p']));

            if (!$row) {
                $this->_view->_error = "Usuario y/o password incorrectos";
                $this->_view->renderizar('index', 'login');
                exit;
            }

            if ($row['estado'] != 1) {
                $this->_view->_error = "Este usuario no esta habilitado";
                $this->_view->renderizar('index', 'login');
                exit;
            }

            Session::set('autenticado', true);
            Session::set('level', $row['role']);
            Session::set('usuario', $row['usuario']);
            Session::set('id_usuario', $row['idUsuario']);
            Session::set('tiempo', time());

            $this->redireccionar('index');
        }

        $this->_view->renderizar('index', 'login');


    }

    public function cerrar()
    {
        Session::destroy();
        $this->redireccionar();
    }
}