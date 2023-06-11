<?php

class UsersProfileModel
{
    private $database;


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUserData($user)
    {
//        $data = array(
//            'nombre_u' => $user
//        );

        $sql = "SELECT nombre_u FROM usuario WHERE nombre_u = ?;";
        $sentencia = $this->database->getConnection()->prepare($sql);
        $sentencia->bind_param('s', $user);
        $sentencia->execute();

        $result = $sentencia->get_result();

        if ($result->num_rows > 0) {
            $data = array(
                'nombre_u' => $user);
        } else {
            $data = array(
                'error' => 'no-user');
        }

        return ['perfilUsuario', $data];
    }

}