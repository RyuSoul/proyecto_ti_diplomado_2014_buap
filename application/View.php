<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 15/04/14
 * Time: 08:26 PM
 */


class View
{
    private $_controlador;
    private $_js;

    public function __construct(Request $peticion)
    {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
    }

    public function renderizar($vista, $item = false)
    {
        $menuPaciente = array(
            array('id' => 'newPatient', 'titulo' => 'Nuevo Paciente', 'enlace' => BASE_URL . 'patients/index'),
            array('id' => 'editPatient', 'titulo' => 'Editar Paciente', 'enlace' => BASE_URL . 'patients/searchPatient'),
            array('id' => 'deletePatient', 'titulo' => 'Eliminar Paciente', 'enlace' => BASE_URL.'patients/deletePatient')
        );

        $menuExpedientes = array(
            array('id' => 'searchRecord', 'titulo' => 'Buscar Expediente', 'enlace' => BASE_URL),
            array('id' => 'editRecord', 'titulo' => 'Editar Expediente', 'enlace' => BASE_URL),
            array('id' => 'historyConsultations', 'titulo' => 'Historial de Consultas', 'enlace' => BASE_URL),
            array('id' => 'historyMedications', 'titulo' => 'Historial de Medicaciones', 'enlace' => BASE_URL)
        );

        $menuNurse = array(
            array('id' => 'newNurse', 'titulo' => 'Nuevo Enferera', 'enlace' => BASE_URL),
            array('id' => 'editNurse', 'titulo' => 'Editar Enfermera', 'enlace' => BASE_URL),
            array('id' => 'deleteNurse', 'titulo' => 'Eliminar Enfermera', 'enlace' => BASE_URL)
        );

        $menuReportes = array(
            array('id' => 'listPatients', 'titulo' => 'Lista de Pacientes', 'enlace' => BASE_URL),
            array('id' => 'listDrogs', 'titulo' => 'Lista de Medicamentos', 'enlace' => BASE_URL),
            array('id' => 'listLaboratories', 'titulo' => 'Lista de Laboratorios', 'enlace' => BASE_URL)
        );

        $js = array();
        if (count($this->_js)) {
            $js = $this->_js;
        }

        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'ruta_js_public'=>BASE_URL.'public/js/jquery.js',
            'menuPaciente' => $menuPaciente,
            'menuExpedientes' => $menuExpedientes,
            'menuNurse' => $menuNurse,
            'menuReportes' => $menuReportes,
            'js' => $js
        );

        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';

        if (is_readable($rutaView)) {

            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            if ($this->_controlador != 'login') {
                include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'aside.php';
            }
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';

        } else {
            throw new Exception('Error de vista');
        }
    }

    public function setJs(array $js)
    {
        if (is_array($js) && count($js)) {
            foreach ($js as $item) {
                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $item . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }
}