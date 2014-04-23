<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 15/04/14
 * Time: 09:19 PM
 */

class indexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_view->titulo = 'Portada';
        $this->_view->renderizar('index');
    }
}