<?php
include_once ("exeptions/CampoVacioException.php");
include_once ("exeptions/EmailException.php");
include_once ("exeptions/PasswordException.php");
include_once ("exeptions/PasswordsRepetidosException.php");
include_once ("exeptions/SexoException.php");
include_once ("exeptions/NacimientoException.php");
class RegistroModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function validarCampos()
    {
        $errores = array();
        $validos = array();

        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordRepetido = $_POST['repetir-password'];
        $pais = $_POST['pais'];
        $provincia = $_POST['provincia'];
        $sexo = $_POST['sexo'];
        $nacimiento = $_POST['nacimiento'];
        $imagen = $_FILES['imagen']['tmp_name'];


        try {
            $this->validarCampoVacio($imagen, 'Imagen');
            $validos["imagen"] = $imagen;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarCampoVacio($usuario, 'Usuario');
            $validos['usuario'] = $usuario;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarCampoVacio($usuario, 'Nacimiento');
            $validos['nacimiento'] = $usuario;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarCampoVacio($nombre, 'Nombre');
            $validos['nombre'] = $nombre;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarCampoVacio($apellido, 'Apellido');
            $validos['apellido'] = $apellido;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarCampoVacio($pais, 'País');
            $validos['pais'] = $pais;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarCampoVacio($provincia, 'Provincia');
            $validos['provincia'] = $provincia;
        }catch(CampoVacioException $e){
            $errores[$e->getCampo()] = $e->getMessage();
        }
        try {
            $this->validarEmail($email);
            $validos['email'] = $email;
        }catch(EmailException $e){
            $errores['email'] = $e->getMessage();
        }
        try {
            $this->validarPassword($password);
            $validos['password'] = $password;
        }catch(PasswordException $e){
            $errores['password'] = $e->getMessage();
        }
        try {
            $this->validarPasswordsRepetidos($password, $passwordRepetido);
        }catch(PasswordsRepetidosException $e){
            $errores['passwordDistinto'] = $e->getMessage();
        }
        try {
            $this->validarSexo($sexo);
            $validos['sexo'] = $sexo;
        }catch(SexoException $e){
            $errores['sexo'] = $e->getMessage();
        }
        try {
            $this->validarNacimiento($nacimiento);
            $validos['nacimiento'] = $nacimiento;
        }catch(NacimientoException $e){
            $errores['nacimiento-rango'] = $e->getMessage();
        }

        if(empty($errores)) {

            $this->persistirDatos($validos);
            return ['errores' => $errores, 'valido' => $validos];
        }
        $validos['codigo'] = $this->generarCdigo();
        $this->mandarCdigo($validos['codigo']);
        return ['errores' => $errores, 'valido' => $validos];

    }

    private function validarCampoVacio($valor, $nombreCampo)
    {
        if (empty($valor)) {
            throw new CampoVacioException("El campo $nombreCampo es obligatorio", $nombreCampo);
        }
    }
    private function validarEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailException("El email no es válido");
        }
    }
    private function validarPassword($password)
    {
        $regexPass = '/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$)(?=.*[;:\.,!¡\?¿@#\$%\^&\-_+=\(\)\[\]\{\}])).{4,20}$/';
        if(!preg_match($regexPass, $password)){
            throw new PasswordException("La contraseña debe contener al menos un dígito, una letra minúscula, una letra mayúscula, no contener espacios en blanco, al menos un carácter especial, y tener una longitud entre 4 y 20 caracteres");
        }
    }
    private function validarPasswordsRepetidos($password, $passwordRepetido)
    {
        if(!$password == $passwordRepetido){
            throw new PasswordsRepetidosException("Las contraseñas no coinciden");
        }
    }
    private function validarSexo($sexo) {
        $sexosPermitidos = array('Masculino', 'Femenino', 'Prefiero no cargarlo');
        if (!in_array($sexo, $sexosPermitidos)) {
            throw new SexoException("El valor del campo de sexo no es válido");
        }
    }

    private function validarNacimiento($nacimiento)
    {
        $nacimiento = new DateTime($nacimiento);
        $hoy = new DateTime();

        if ($nacimiento > $hoy) {
            throw new NacimientoException("La fecha de nacimiento no puede ser mayor a la fecha actual");
        }
    }

    private function persistirDatos($validos)
    {
        $passHash = $this->hashearPassword($validos['password']);
        $imagen = file_get_contents($validos['imagen']);
        $sql = "INSERT INTO usuario (`foto_perfil`, `nombre_u`, `nombre`, `apellido`, `email`, `password`, `fecha_nac`, `sexo`, `pais`, `provincia`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $sentencia = $this->database->getConnection()->prepare($sql);

        $sentencia->bind_param("ssssssssss",
            $imagen,
            $validos['usuario'],
            $validos['nombre'],
            $validos['apellido'],
            $validos['email'],
            $passHash,
            $validos['nacimiento'],
            $validos['sexo'],
            $validos['pais'],
            $validos['provincia']
        );


        $sentencia->execute();

    }

    public function hashearPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
        //return md5($password);
    }
    private function generarCdigo()
    {
        $codigo = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        return $codigo;
    }

    private function mandarCdigo(string $codigo)
    {

    }
}