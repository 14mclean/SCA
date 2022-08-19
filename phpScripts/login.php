<?php
    ini_set("display_errors", 1); // show errors in html (remove after dev)

    require "connectDB.php"; // connect to database

    $passHash = hash("sha256", $_POST["password"]); // hash user inputted password

    
    $statement = $conn->prepare(
        "SELECT userID,emailverified,userLevel FROM Users WHERE email = ? AND passwordHash = ?"     // prepare universal statement to get for user fitting GET variables
    );
    $statement->bind_param("ss", $_POST["email"], $passHash);
    $statement->execute();

    if($statement->num_rows == 1) { // if details match any in login db
        $result = $statement->fetch_assoc();

        if($result->fetch_column(1) == 1) { // if email has been verified
            session_start();
            $_SESSION["userID"] = $result->fetch_column(0); // get userID matching details and add to session
            $_SESSION["userLevel"] = $result->fetch_column(2); // get user's permissions and add to session
            
            header("Location: ../webpages/directoryresults.php"); // redirect to directory
        } else {
            header("Location: ../webpages/login.php?loginError=verifiedEmail"); // report non-verified email
        }
    } else {
        header("Location: ../webpages/login.php?loginError=login"); // report incorrect details
    }
    $statement->close();
    exit();
?>
