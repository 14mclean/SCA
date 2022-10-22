<?php
    ini_set('display_errors', 1);

    include_once("database.php");

    $db = new Database();

    $statement = $db->prepareStatement(
        "SELECT name,link FROM ExpertResources WHERE userID=?",
        "i",
        array($_GET["userid"])
    );

    $result = $db->sendQuery($statement);
    print_r(json_encode($result));

?>