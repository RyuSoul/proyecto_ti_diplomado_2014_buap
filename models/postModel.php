<?php
/**
 * Created by PhpStorm.
 * User: Cesar Luis Rosagel
 * Date: 16/04/14
 * Time: 02:48 PM
 */

class postModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPosts()
    {
        $post = array(
            'id' => 1,
            'titulo' => 'Titulo Post',
            'cuerpo' => 'Cuerpo Post...'
        );

        return $post;
    }
}