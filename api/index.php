<?php

    // $_SERVER["REQUEST_URI"] = post-hostname path
    $url = substr($_SERVER["REQUEST_URI"], 4);
    $parts = explode("/", $url);
    var_dump($parts);