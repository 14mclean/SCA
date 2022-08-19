<?php 

    ini_set('display_errors', 1);
    require 'connectDB.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [
        "charLengthError" => strlen($password) < 8, // Password length >= 8
        "numError" => preg_match('@[0-9]@', $password) < 1, // Password number characters >= 1
        "uppercaseError" => preg_match('@[A-Z]@', $password) < 1, // Password uppercase characters >= 1
        "lowercaseError" => preg_match('@[a-z]@', $password) < 1, // Password lowercase characters >= 1
        "emailTakenError" => false // E-mail must be unique
    ];

    if(in_array(true)) {
        $passHash = hash('sha256', $password);

        $statement = $conn->prepare(
            "INSERT INTO Users (email,passwordHash,emailVerified,userLevel) VALUES (?,?,0,'Teacher');"
        );
        $statement->bind_param("ss", $email, $passHash);
        $statement->execute();
    } 

    $url = "Location: ../webpages/usersignup?";

    foreach ($errors as $key => $value) {
        if(array_search($key, array_keys($errors)) != 0) {
            $url .= "&";
        }
        $url .= "$key=";
        if($value) {
            $url .= "true";
        } else {
            $url .= "false";
        }
    }

    header($url);
    exit();
?>