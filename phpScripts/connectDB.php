<?php
    $conn = new mysqli('localhost', 'mwd3iqjaesdr', 'cPanMT3', 'SchoolCitizenAssemblies');

    if($conn->connect_error) {
        exit($conn->connect_error);
        // Couldn't connect to server, inncorrect username/passwd?
    }
?>