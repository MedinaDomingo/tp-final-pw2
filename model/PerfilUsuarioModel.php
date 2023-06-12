<?php

class PerfilUsuarioModel
{
    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getData($user){

        //Trar mas data da la bd a ser necesario y poblar el array

        $data = array(
            'nombre_u' => $user
        );

        //Retorna la vista que renderizar ya los datos con los que poblar la vista
        //Estos datos estan el el .mustache entre llaves dobles {{Algo}}
        return ["perfilUsuario", $data];
    }

}