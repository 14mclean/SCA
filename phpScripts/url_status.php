<?php

// save preivous context options
$previous_options = stream_context_get_options(stream_context_get_default());

stream_context_set_default([    // set timeout to 1 second
    'http' => ['timeout' => 1]
]);

@$http_status_code = substr( get_headers($_GET["url"])[0], 9, 3); // extract status code from response

if($http_status_code == "") $http_status_code = "404"; // ensure proper stauts code is returned

stream_context_set_default($previous_options);
echo $http_status_code;