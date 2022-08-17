<?php

    ini_set("display_errors", 1); // show errors in html (remove after dev)

    require "connectDB.php"; // connect to database

    $passHash = hash("sha256", $_POST["password"]); // hash user inputted password

    
    $statement = $conn->prepare(
        "SELECT userID,emailVarified,userLevel FROM Users WHERE email = ? AND passwordHash = ?"     // prepare universal statement to get for user fitting GET variables
    );
    $statement->bind_param("ss", $_POST["email"], $passHash); // input get variables to 
    $statement->execute(); // execute query     

    if($statement->num_rows() == 1) { // if details match any in login db
        $result = $statement->get_result();
        if($result->fetch_column(1) == 1) { // if email has been varified
            session_start();
            $_SESSION["userID"] = $result->fetch_column(0); // get userID matching details and add to session
            $_SESSION["userLevel"] = $result->fetch_column(2); // get user's permissions and add to session
            $statement->close();

            header("Location: ../webpages/directoryresults"); // redirect to directory
        } else {
            header("Location: ../webpages/userlogin?loginError=varifiedEmail"); // report non-varified email
        }
    } else {
        header("Location: ../webpages/userlogin?loginError=login"); // report incorrect details
    }
    exit();
?>
