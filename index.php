<?php
/*session_start();*/

include_once('Configuration.php');

/*if (isset($_GET['controller']) && $_GET['controller'] == "logout") {
    session_unset();
    session_destroy();
    header("Location: /");
    exit;
}*/


$configuration = new Configuration();
$router = $configuration->getRouter();

$module = $_GET['module'] ?? 'login';
$method = $_GET['method'] ?? 'mostrarLogin';

if(!isset($_SESSION['valid'])){
    session_abort();
}
    session_start();

$router->route($module, $method);



