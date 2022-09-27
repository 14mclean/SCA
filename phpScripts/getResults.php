<?php
    ini_set('display_errors', 1);

    include_once("database.php");

    print_r($_GET);

    if(isset($_GET["expertise"])) {
        $innerStatementString = "SELECT userID, location, SOUNDEX(expertise) as fuzzyExpertise FROM Experts WHERE adminVerified=1";
        $statementString = "SELECT userID, location, fuzzyExpertise FROM (".$innerStatementString.") AS temp WHERE fuzzyExpertise=SOUNDEX(?)";
    } else {
        $statementString = "SELECT userID, location FROM Experts WHERE adminVerified=1";
    }

    $db = new Database();

    $statement = $db->prepareStatement(
        $statementString,
        "s",
        array($_GET["expertise"])
    );
?>

