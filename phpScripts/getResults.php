<?php
    // expertise SOUNDEX

    /*
    [adminVerified] => 1
    [outcode] => WA13
    [expertise] => exp
    [distanceRange] => 30
    [wwf] => 1
    [nationaltrust] => 1
    [mbs] => 1
    [unicef] => 1
    [oxfam] => 1
    [age1] => 1
    [age2] => 1
    [age3] => 1
    [age4] => 1
    [age5] => 1
    [teacherAdvice] => 1
    [studentInteraction] => 1
    [projectWork] => 1
    [online] => 1
    [f2f] => 1
    [resources] => 1
    */

    ini_set('display_errors', 1);

    include_once("database.php");

    if(isset($_GET["expertise"])) {
        $innerStatementString = "SELECT userID, location, SOUNDEX(expertise) as fuzzyExpertise FROM Experts WHERE adminVerified=1";
        $statementString = "SELECT userID, location, fuzzyExpertise FROM ("+$innerStatementString+") AS temp WHERE fuzzyExpertise=SOUNDEX(?)";
    } else {
        $statementString = "SELECT userID, location FROM Experts WHERE adminVerified=1"
    }

    

    if(isset($_GET["expertise"])) {
        
    }

    $db = new Database();

    $statement = $db->prepareStatement(
        ,
        "s",
        array($_GET["expertise"])
    );
?>

