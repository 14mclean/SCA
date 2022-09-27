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

    $db = new Database();

    $statement = $db->prepareStatement(
        "SELECT userID, SOUNDEX(expertise) as fuzzyExpertise FROM Experts WHERE adminVerified=1 AND ",
        "",
        array()
    );
?>