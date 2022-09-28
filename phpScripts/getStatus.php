<?php
    $headers = get_headers($_GET["url"]);
    $httpStatusCode = substr($headers[0], 9, 3);
    print($_GET["url"]);
    print_r("\n");
    print_r($httpStatusCode);
?>