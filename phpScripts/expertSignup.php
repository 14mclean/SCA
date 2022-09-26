<?php

    ini_set('display_errors', 1);

    include_once("database.php");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [
        "charLengthError" => strlen($password) < 8, // Password length >= 8
        "numError" => preg_match('@[0-9]@', $password) < 1, // Password number characters >= 1
        "uppercaseError" => preg_match('@[A-Z]@', $password) < 1, // Password uppercase characters >= 1
        "lowercaseError" => preg_match('@[a-z]@', $password) < 1, // Password lowercase characters >= 1
        "emailTakenError" => false // E-mail must be unique
    ];

    if(!in_array(true, $errors)) {
        $db = new Database();

        $passHash = hash('sha256', $password);

        $statement = $db->prepareStatement(
            "INSERT INTO Users (email,passwordHash,emailVerified,userLevel) VALUES (?,?,0,'Expert');",
            "ss",
            array($email, $passHash)
        );

        $response = $db->sendQuery($statement, array());

        $errors["emailTakenError"] = $response == 1062; // ER_DUP_ENTRY
    }

    if(in_array(true, $errors)) {
        $location = "Location: ../webpages/expertsignup.php?";

        foreach ($errors as $key => $value) {
            if(array_search($key, array_keys($errors)) != 0) {
                $location .= "&";
            }
            $location .= "$key=";
            if($value) {
                $location .= "true";
            } else {
                $location .= "false";
            }
        }

        header($location);
    } else {
        $statement = $db->prepareStatement(
            "SELECT userID FROM Users WHERE email=?",
            "s",
            array($email)
        )
        $userID = $db->sendQuery($statement, array("userID"))[0]["userID"];


        $statement = $db->prepareStatement(
            "INSERT INTO Experts (userID, adminVerified)",
            "ii",
            array($userID,0)
        );

        $db->sendQuery($statement, array());

        header("Location: ../webpages/verifyemail.html");
    }
    exit();
?>