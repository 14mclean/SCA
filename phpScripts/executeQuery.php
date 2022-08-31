<?php
    ini_set("display_errors", 1); // show errors in html (remove after dev)

    include_once("database.php");

    $db = new Database();

    $statement = $db->prepareStatement(
        $_POST["statement"],
        $paramTypes,
        array()
    );
    $db->sendQuery($statement, array());

    header("Location:".$_SERVER["HTTP_REFERER"]);
    exit();
?>