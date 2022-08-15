<?php
    ini_set('display_errors', 1);
    require 'connectDB.php';
    
    $errors = array();
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, 'Invalid email');
    }
    
    $errors = [
        "charLengthError" => strlen($password) < 8, // Password length >= 8
        "numError" => preg_match('@[0-9]@', $password) < 1, // Password number characters >= 1
        "uppercaseError" => preg_match('@[A-Z]@', $password) < 1, // Password uppercase characters >= 1
        "lowercaseError" => preg_match('@[a-z]@', $password) < 1, // Password lowercase characters >= 1
        "emailTakenError" => false // E-mail must be unique
    ];
    
    if(isError($errors)) {
        $passHash = hash('sha256', $password);
        $query = "INSERT INTO Users (email, passwordHash) VALUES ('$email','$passHash');";

        try {
            $result = $conn->query($query);
        } catch(Exception $e) {
            $errors["emailTakenError"] = true;
            errorOccured($errors);
        }
        
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["loginType"] = "teacher";
        header("Location: ../webpages/directoryresults.php");
        exit();
    } else {
        errorOccured($errors);
    }

    function isError($errors) {
        foreach ($errors as $key => $value) {
            if($value == true) {
                return true;
            }
        }
        return false;
    }

    function errorOccured($errors) {
        $url = "Location: ../webpages/usersignup.php?";

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
    }
?>