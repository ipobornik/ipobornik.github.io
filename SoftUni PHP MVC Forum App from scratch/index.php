<?php

session_start();

require_once ('includes/config.php');

$requestParts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$controllerName = DEFAULT_CONTROLLER;
if (count($requestParts) >= 2 && $requestParts[1] != '') {
	$controllerName = $requestParts[1];
}

$action = DEFAULT_ACTION;
if (count($requestParts) >= 3 && $requestParts[2] != '') {
	$action = $requestParts[2];
}

$params = array_splice($requestParts, 3);

$controllerClassName = ucfirst(strtolower($controllerName)) . 'Controller';
$controllerFileName = "controllers/" . $controllerClassName . '.php';

if (class_exists($controllerClassName)) {
	$controller = new $controllerClassName($controllerName, $action);
} else {
	die("Cannot find controller '$controllerName' in class '$controllerFileName'");
}

if (method_exists($controller, $action)) {
	call_user_func_array(array($controller, $action), $params);
} else {
	die("Cannot find action '$action' in controller '$controllerClassName'");
}


function __autoload($class_name) {
	if (file_exists("controllers/$class_name.php")) {
		include "controllers/$class_name.php";
	}
	
	if (file_exists("models/$class_name.php")) {
		include "models/$class_name.php";
	}
}
