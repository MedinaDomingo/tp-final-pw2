<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');

include_once('controller/LoginController.php');
include_once('controller/RegistroController.php');

include_once('model/RegistroModel.php');
include_once('model/LoginModel.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');


class Configuration
{
    private $configFile = 'config/config.ini';

    public function __construct()
    {
    }
    public function getLoginController()
    {
        return new LoginController(new loginModel($this->getDatabase()), $this->getRenderer());
    }
    public function getRegistroController()
    {
        return new RegistroController(new RegistroModel($this->getDatabase()), $this->getRenderer());
    }

    private function getArrayConfig()
    {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer()
    {
        return new MustacheRender('view/partial');
    }

    public function getDatabase()
    {
        $config = $this->getArrayConfig();
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