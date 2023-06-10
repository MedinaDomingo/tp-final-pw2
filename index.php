<?php
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

$module = $_GET['module'] ?? 'login';
$method = $_GET['method'] ?? 'mostrarLogin';

if(!isset($_SESSION['valid'])){
    session_abort();
}
    session_start();

$router->route($module, $method);

