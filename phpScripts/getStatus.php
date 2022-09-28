<?php
    try {
        $headers = get_headers($_GET["url"]);
        $httpStatusCode = substr($headers[0], 9, 3);
        echo($httpStatusCode);
    } catch(Exception $e) {
        echo("404");
    }
?>