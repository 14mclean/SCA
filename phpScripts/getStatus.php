<?php
    $url = $_GET["url"];
    $headers = get_headers($url);
    $httpStatusCode = substr($headers[0], 9, 3);
    print_r($httpStatusCode);
?>