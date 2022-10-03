<?php

    // $_SERVER["REQUEST_URI"] = post-hostname path
    $url = substr($_SERVER["REQUEST_URI"], 4);
    $parts = array_slice(explode("/", $url),1);
    
    if($parts[0] != "experts") {
        http_response_code(404);
        exit();
    }

    $id = $parts[1] ?? null;
    var_dump($id);