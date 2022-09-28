<?php
    try {
        $headers = get_headers($_GET["url"]);
        $httpStatusCode = substr($headers[0], 9, 3);
        print_r($httpStatusCode);
    } catch(Exception $e) {
        print_r("404");
    }
?>