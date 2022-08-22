<?php
    ini_set("display_errors", 1); // show errors in html (remove after dev)

    include_once("database.php");

    $passHash = hash("sha256", $_POST["password"]); // hash user inputted password

    $db = new Database();

    $statement = $db->prepareStatement(
        "SELECT userID,emailverified,userLevel FROM Users WHERE email = ? AND passwordHash = ?",
        "ss",
        array($_POST["email"], $passHash)
    );    

    $result = $db->getResult($statement, array("userID", "verifiedEmail", "userLevel"));

    var_dump($result);
?>
