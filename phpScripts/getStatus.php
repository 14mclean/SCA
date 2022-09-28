<?php
    @$headers = get_headers($_GET["url"]);
    @$httpStatusCode = substr($headers[0], 9, 3);
    if($httpStatusCode == "") {
        $httpStatusCode = "404";
    }
    print_r($httpStatusCode);
?>