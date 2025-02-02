<?php

declare(strict_types=1);
spl_autoload_register(function($class) {require __DIR__ . "/$class.php";}); // load any not imported classes (assuming their classname=filename)
set_error_handler("ErrorHandler::handle_error"); // set custom error handler
set_exception_handler("ErrorHandler::handle_exception"); // set custom exception handler

header("Content-type: application/json; charset=UTF-8"); // set response type as json

$url = substr($_SERVER["REQUEST_URI"], 5); // remove "/api" from URL
$parts = preg_split("/[\/?]/", $url);
$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3"); // config file for hardcoded data?

switch($parts[0]) {
    case "experts":
        $gateway = new ExpertGateway($db);
        $controller = new ExpertController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], explode("/", $url));
        break;
    case "users":
        $gateway = new UserGateway($db);
        $controller = new UserController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], explode("/", $url));
        break;
    case "expertresources":
        $gateway = new ExpertResourceGateway($db);
        $controller = new ExpertResourceController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], explode("/", $url));
        break;
    case "emailcodes":
        $gateway = new EmailCodesGateway($db);
        $controller = new EmailCodesController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], explode("/", $url));
        break;
    case "expertise":
        $gateway = new ExpertiseGateway($db);
        $controller = new ExpertiseController($gateway);
        $controller->process_request($_SERVER["REQUEST_METHOD"], explode("/", $url));
        break;
    default:
        http_response_code(404);
        exit();
}