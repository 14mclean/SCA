<?php
    declare(strict_types=1);
    spl_autoload_register(function($class) {require __DIR__ . "/$class.php";});

    header("Content-type: application/json; charset=UTF-8");

    $url = substr($_SERVER["REQUEST_URI"], 4);
    $parts = array_slice(explode("/", $url),1);
    
    if($parts[0] != "experts") {
        http_response_code(404);
        exit();
    }

    $id = $parts[1] ?? null;

    $db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3"); // config file for hardcoded data?
    $db->get_connection();

    $controller = new ExpertController;
    $controller->process_request($_SERVER["REQUEST_METHOD"], $id);