<?php
    ini_set("display_errors", 1); // show errors in html (remove after dev)

    $passHash = hash("sha256", $_POST["password"]); // hash user inputted password

    $db = new Database();

    $statement = $conn->prepare(
        "SELECT userID,emailverified,userLevel FROM Users WHERE email = ? AND passwordHash = ?"     // prepare universal statement to get for user fitting GET variables
    );
    $statement->bind_param("ss", $_POST["email"], $passHash);
    

    $result = $db->getResult($statement, array("userID", "verifiedEmail", "userLevel"));

    var_dump($result);
?>
