<?php
    try {
        $headers = get_headers($_GET["url"]);
    } catch(Exception $e) {
        echo("404");
        return
    }
    $httpStatusCode = substr($headers[0], 9, 3);
    echo($httpStatusCode);
?>