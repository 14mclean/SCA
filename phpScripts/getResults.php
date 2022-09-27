<?php
    ini_set('display_errors', 1);

    include_once("database.php");

    print_r($_GET);

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

    if(isset($_GET["expertise"])) {
        $innerStatementString = "SELECT userID, location, SOUNDEX(expertise) as fuzzyExpertise FROM Experts WHERE adminVerified=1";
        $statementString = "SELECT userID, location, fuzzyExpertise FROM (".$innerStatementString.") AS temp WHERE fuzzyExpertise=SOUNDEX(?)";
    } else {
        $statementString = "SELECT userID, location FROM Experts WHERE adminVerified=1";
    }

    print_r($statementString);

    $db = new Database();

    $statement = $db->prepareStatement(
        $statementString,
        "s",
        array($_GET["expertise"])
    );
?>

