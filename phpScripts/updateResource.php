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

    $userID = $_POST["userID"];
    $newResources = array_slice($_POST, 1, count($_POST), true);

    foreach ($newResources as $name => $link) {
        $newResources[str_replace("_"," ",$name)] = $link;
        unset($newResources[$name]);
    }

    $db = new Database();

    $statement = $db->prepareStatement(
        "SELECT resourceID,name,link FROM ExpertResources WHERE userID=?;",
        "i",
        array($userID)
    );
    $currentResources = $db->sendQuery($statement, array("resourceID", "name", "link"));

    foreach ($currentResources as $key => $value) {
        if(array_key_exists($value["name"], $newResources) && $newResources[$value["name"]] == $value["link"]) {
            unset($currentResources[$key]);
            unset($newResources[$value["name"]]);
        }
    }

    print_r($currentResources);
    print_r("<br>");
    print_r($newResources);

    foreach ($currentResources as $value) {
        // delete
        $statement = $db->prepareStatement(
            "DELETE FROM ExpertResources WHERE resourceID=?;",
            "i",
            array($value["resourceID"])
        );
        $db->sendQuery($statement, array());
    }

    foreach ($newResources as $name => $link) {
        // insert
        $statement = $db->prepareStatement(
            "INSERT INTO ExpertResources (userID,name,link) VALUES (?,?,?);",
            "iss",
            array($userID,$name, $link)
        );
        $db->sendQuery($statement, array());
    }

    /*

    db: Array ( [0] => Array ( [resourceID] => 1 [name] => Exmaple Resource [link] => test.com/exampleresource ) )
    post: Array ( [userID] => 1 [Exmaple_Resource] => http://www.google.co.uk )

    */
?>