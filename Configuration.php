<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');


include_once('controller/LoginController.php');
include_once('controller/RegistroController.php');
include_once('controller/PerfilUsuarioController.php');
include_once ('controller/LobbyController.php');
include_once ('controller/PartidaController.php');
<<<<<<< HEAD
include_once ('controller/UsersProfileController.php');
=======
include_once ('controller/RankingController.php');
>>>>>>> 2c3170c14d372b4d3479ef0b6d6ac1f631dca056

include_once('model/RegistroModel.php');
include_once('model/LoginModel.php');
include_once('model/EmailModel.php');
include_once('model/PerfilUsuarioModel.php');
include_once('model/PartidaModel.php');
include_once('model/LobbyModel.php');
<<<<<<< HEAD
include_once ('model/UsersProfileModel.php');
=======
include_once('model/RankingModel.php');
>>>>>>> 2c3170c14d372b4d3479ef0b6d6ac1f631dca056



include_once('third-party/mustache/src/Mustache/Autoloader.php');


class Configuration
{
    private $configFile = 'config/config.ini';
    private $configEmail = 'config/config-email.ini';

    public function __construct()
    {
    }
    public function getLoginController()
    {
        return new LoginController(new loginModel(
            $this->getDatabase()),
            $this->getRenderer());
    }
    public function getRegistroController()
    {
        $config = $this->getArrayConfig($this->configEmail);

        return new RegistroController(new RegistroModel($this->getDatabase(), new Email(
            $config['name'], $config['username'], $config['password'], $config['host'], $config['port'])),
            $this->getRenderer());
    }

    //get *NombreDeClase* ()
    //retorna un nuevo objeto de esa clase, el controllador necesita un modelo y el renderer,
    //el modelo es a necesidad el renderer para que se renderice la pagina
    public function getPerfilUsuarioController(){
        return new PerfilUsuarioController(new PerfilUsuarioModel(
            $this->getDatabase()),
            $this->getRenderer());
    }

    public function getUsersProfileController(){
        return new UsersProfileController(new UsersProfileModel(
            $this->getDatabase()),
            $this->getRenderer());
    }

    public function getPartidaController(){
        return new PartidaController(new PartidaModel(
            $this->getDatabase()),
            $this->getRenderer());
    }

    public function getLobbyController(){
        return new LobbyController(new LobbyModel(
            $this->getDatabase()),
            $this->getRenderer());
    }

    public function getRankingController(){
        return new RankingController(new RankingModel(
            $this->getDatabase()),
            $this->getRenderer());
    }
    private function getArrayConfig($ruta)
    {
        return parse_ini_file($ruta);
    }

    private function getRenderer()
    {
        return new MustacheRender('view/partial');
    }

    public function getDatabase()
    {
        $config = $this->getArrayConfig($this->configFile);
        return new MySqlDatabase(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['database']
        );
    }

    public function getRouter()
    {
        return new Router(
            $this,
            "getLoginController",
            "mostrarLogin"
        );
    }
}