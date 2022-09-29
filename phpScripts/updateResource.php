<?php

    ini_set('display_errors', 1);

    include_once("database.php");

    /*
    SELECT * FROM ExpertResources WHERE userID=?;

    if duplicate remove from both arrays

    for current resources without duplicate:
        DELETE FROM ExpertResources WHERE resourceID=?;

    for new resoureces without duplicates:
        INSERT INTO ExpertResources (userID,name,link) VALUES (?,?,?);

    */

    $db = new Database();

    $statement = $db->prepareStatement(
        "SELECT resourceID,name,link FROM ExpertResources WHERE userID=?;",
        "i",
        array($_POST["userID"])
    );
    $currentResources = $db->sendQuery($statement, array("resourceID", "name", "link"));

    print_r($currentResources);
    print_r("<br>");
    print_r($_POST);

    /*

    db: Array ( [0] => Array ( [resourceID] => 1 [name] => Exmaple Resource [link] => test.com/exampleresource ) )
    post: Array ( [userID] => 1 [resourceNames] => [object NodeList] [resourceLinks] => [object NodeList] )

    */
?>