<?php
    declare(strict_types=1);
    spl_autoload_register(function($class) {require __DIR__ . "/$class.php";});

    $url = substr($_SERVER["REQUEST_URI"], 4);
    $parts = array_slice(explode("/", $url),1);
    
    if($parts[0] != "experts") {
        http_response_code(404);
        exit();
    }

    $id = $parts[1] ?? null;

    $controller = new ExpertController;
    $controller->process_request($_SERVER["REQUEST_METHOD"], $id);