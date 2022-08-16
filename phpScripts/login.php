<?php

    ini_set("display_errors", 1); // show errors in html (remove after dev)

    require "connectDB.php";

    $email = $_POST["email"];
    $password = $_POST["password"];
    $passHash = hash("sha256", $password);

    $statement = $conn->prepare(
        "SELECT * FROM Users WHERE email = ? AND passwordHash = ?"
    );
    $statement->bind_param("ss", $email, $passHash);
    $statement->execute();
    $loginMatch = $statement->num_rows() == 1;
    

    if($loginMatch) {
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["userLevel"] = $statement->get_result()->fetch_column(4);
        $statement->close();

        header("Location: ../webpages/directoryresults");
    } else {
        header("Location: ../webpages/userlogin?loginError=true");
    }
    
    exit();
?>
