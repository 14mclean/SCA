<?php
    ini_set('display_errors', 1);

    include_once("database.php");

    /*
        [adminVerified] => 1 /
        [teacherAdvice] => 1 /
        [projectWork] => 1 /
        [studentOnline] => 1 /
        [studentF2F] => 1 /
        [studentResources] => 1 /
        [ages] => ks1,ks2,ks3,ks4,ks5
        [orgs] => wwf,nationaltrust,mbs,unicef,oxfam
        [expertise] => blah /
    */

    $filter = "";

    foreach ($_GET as $key => $value) {
        if($key != "adminVerified" && $value == 1) {
            $filter .= " AND ".$key."=1";
        }
    }

    $db = new Database();

    if(isset($_GET["expertise"])) {
        $statement = $db->prepareStatement(
            "SELECT userID, location FROM Experts WHERE adminVerified=1 AND expertise SOUNDS LIKE ?",
            "s",
            array($_GET["expertise"])
        );
    } else {
        $statement = $db->prepareStatement(
            "SELECT userID, location FROM Experts WHERE adminVerified=1",
            "",
            array()
        );
    }

    $result = $db->sendQuery($statement, array("userID, location, fuzzyExpertise"));
    print_r($result);
?>


