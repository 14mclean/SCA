<?php

    // $_SERVER["REQUEST_URI"] = post-hostname path
    $url = substr($_SERVER["REQUEST_URI"], 4)
    var_dump($url);