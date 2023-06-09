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
        $sql = "SELECT nombre_u, puntaje, pais, provincia, foto_perfil FROM usuario WHERE nombre_u = '$user'";
        $result = $this->database->query($sql)[0];
        $data = array(
            'nombre_u' => $result["nombre_u"],
            'foto_perfil' => $result["foto_perfil"],
            'puntaje' => $result["puntaje"],
            'pais' => $result["pais"],
            'provincia' => $result["provincia"],
        );

        //Retorna la vista que renderizar ya los datos con los que poblar la vista
        //Estos datos estan el el .mustache entre llaves dobles {{Algo}}
        return ["perfilUsuario", $data];
    }

}