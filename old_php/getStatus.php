<?php
    $previousContext = stream_context_get_options(stream_context_get_default());

    stream_context_set_default([
        'http' => [
            'timeout' => 2
        ]
    ]);

    @$headers = get_headers($_GET["url"]);
    @$httpStatusCode = substr($headers[0], 9, 3);
    if($httpStatusCode == "") {
        $httpStatusCode = "404";
    }

    stream_context_set_default($previousContext);

    print_r($httpStatusCode);
?>