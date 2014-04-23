<?php
/**
 * Created by PhpStorm.
 * User: paola adriana rodriguez leyva
 * Date: 15/04/14
 * Time: 08:25 PM
 */

class Model
{
    protected $_db;

    public function __construct()
    {
        $this->_db = new Database('pgsql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }
}
