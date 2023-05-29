<?php

class loginModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function validarUsuario()
    {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        if(empty($usuario) || empty($password)){
            return ["login", ["mensaje"=>"Usuario o contraseña incorrecta"]];
        }


        $sql = "SELECT * FROM usuario WHERE nombre_u = '$usuario'";

        $usuarioQuey = $this->database->query($sql);



        if (password_verify($password, $usuarioQuey[0]['password'])) {
            return $this->validarActivo($usuarioQuey[0]);
        } else {
            return ["login", ["mensaje"=>"Usuario o contraseña incorrecta"]];
        }
    }

    private function validarActivo($usuario)
    {
        return $usuario['isActivo'] == 1 && $usuario['rol'] == 1 ?
            ["perfilUsuario", $usuario ]: ($usuario['isActivo'] == 1 && $usuario['rol'] == 2 ?
                "perfiladm": ["login", ["mensaje"=>"No te pases de gil tenes que validar la cuenta"]]);
    }


}