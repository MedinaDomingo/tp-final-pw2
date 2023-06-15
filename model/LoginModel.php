<?php


class LoginModel

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

        if (empty($usuario) || empty($password)) {

            return ["login", ["mensaje" => "Usuario o contraseña incorrecta"]];
        }

        $sql = "SELECT * FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE nombre_u = '$usuario'";

        $usuarioQuery = $this->database->query($sql);

        if (password_verify($password, $usuarioQuery[0]['password'])) {
            return $this->validarActivo($usuarioQuery[0]);
        } else {
            return ["login", ["mensaje" => "Usuario o contraseña incorrecta"]];
        }
    }

    private function validarActivo($usuario)
    {
        //NOTA:
        //rol despues hay que pasarlo a id_rol y consultar la tabla de roles para saber donde puede ir, a
        //ca deberia ir en base a ese id otro criteria

        //*** Criteria for rol goes here ***//

        return $usuario['is_active'] == 1 && $usuario['descripción'] == "cliente" ?
            ["lobby", $usuario] : ($usuario['is_active'] == 1 && $usuario['descripción'] == "editor" ?
                ["editor", $usuario]  : ["login", ["mensaje" => "No te pases de gil tenes que validar la cuenta"]]);

    }

}