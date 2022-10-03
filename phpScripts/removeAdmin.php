<?php

    ini_set('display_errors', 1);
    include_once("database.php");

    $email = $_POST["email"];

    $db = new Database();
    $staatement = $db->prepareStatement(
        "DELETE FROM Experts WHERE email=?",
        "s",
        array($email)
    );
    $db->sendQuery($statement);

?>