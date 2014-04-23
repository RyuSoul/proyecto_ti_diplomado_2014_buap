<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 19/04/14
 * Time: 11:07 AM
 */
class ajaxModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPaises()
    {
        $paises=$this->_db->select("Pais");

        return $paises;
    }

    public function getEstados($pais)
    {
        $bind=array(
          ":idPais"=>$pais
        );
       $fields=array("idEstado","nombre");
       $estados=$this->_db->select("Estado","\"idPais_Pais\"=:idPais",$bind,$fields);
        return $estados;
    }

    public function getMunicipios($estado)
    {
        $bind=array(
            ":idEstado"=>$estado
        );
        $fields=array("idMunicipio","nombre");
        $municipios=$this->_db->select("Municipio","\"idEstado_Estado\"=:idEstado",$bind,$fields);

        return $municipios;
    }

    public  function getLocalidades($municipio){
        $bind=array(
            ":idMunicipio"=>$municipio
        );
        $fields=array("idLocalidadColonia","nombre");
        $localidades=$this->_db->select("LocalidadColonia","\"idMunicipio_Municipio\"=:idMunicipio",$bind,$fields);

        return $localidades;
    }

    public function getCP($idLocalidad){
        $zipCode=$this->_db->run('SELECT cp.codigo FROM "LocalidadColonia" lc,"CodigoPostal" cp
                                  WHERE lc."idMunicipio_Municipio"='.$idLocalidad);

        return $zipCode;
    }
}