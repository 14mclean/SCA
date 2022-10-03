<?php

declare(strict_types=1);
spl_autoload_register(function($class) {require __DIR__ . "/$class.php";}); // load any not imported classes (assuming their classname=filename)
set_error_handler("ErrorHandler::handle_error"); // set custom error handler
set_exception_handler("ErrorHandler::handle_exception"); // set custom exception handler

header("Content-type: application/json; charset=UTF-8"); // set response type as json

$url = substr($_SERVER["REQUEST_URI"], 4); // remove "/api" from URL
$parts = array_slice(explode("/", $url),1);
$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3"); // config file for hardcoded data?

switch($parts[0]) {
    case "experts":
        $id = $parts[1] ?? null;
        $gateway = new ExpertGateway($db);
        $controller = new ExpertController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], $id);
        break;
    case "users":
        $id = $parts[1] ?? null;
        $gateway = new UserGateway($db);
        $controller = new ExpertController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], $id);
        break;
    default:
        http_response_code(404);
        exit();
}