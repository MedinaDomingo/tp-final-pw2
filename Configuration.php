<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');


include_once('controller/LoginController.php');
include_once('controller/RegistroController.php');

include_once('model/RegistroModel.php');
include_once('model/LoginModel.php');
include_once('model/EmailModel.php');


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