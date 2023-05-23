<?php
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

$module = $_GET['module'] ?? 'login';
$method = $_GET['method'] ?? 'mostrarLogin';

$router->route($module, $method);



