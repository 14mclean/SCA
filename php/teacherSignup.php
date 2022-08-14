<?php
    ini_set('display_errors', 1);
    require 'connectDB.php';
    
    $errors = array();
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // check for already used email
    $existingEmailQuery = "SELECT EXISTS(SELECT * from Users WHERE email='$email');";
    $isExisting = mysqli_fetch_array($conn->query($existingEmailQuery))[0][0];
    
    if($isExisting == '1') {
        array_push($errors, 'Email has already been used');
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, 'Invalid email');
    }
    
    $lowercase = preg_match('@[a-z]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $errors = [
        "charLengthError" => false,
        "numError" => false,
        "uppercaseError" => false,
        "lowercaseError" => false,
        "emailTakenError" => false
    ];
    
    if(strlen($password) < 8) {
        $errors["charLengthError"] = true;
    }
    if($number < 1) {
        $errors["numError"] = true;
    }
    if(!$uppercase < 1) {
        $errors["uppercaseError"] = true;
    }
    if(!$lowercase < 1) {
        $errors["lowercaseError"] = true;
    }

    echo($lowercase);
    echo($uppercase);
    echo($number);
    echo(strlen($password));
    print_r($errors);
    
    if(isError($errors)) {
        $passHash = hash('sha256', $password);
        $query = "INSERT INTO Users (email, passwordHash) VALUES ('$email','$passHash');";

        try {
            $result = $conn->query($query);
        } catch(Exception e) {
            $errors["emailTakenError"] = true;
            errorOccured($errors);
        }
        
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["loginType"] = "teacher";
        header("Location: ../directoryresults.php");
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
        $url = "Location: ../usersignup.php?";

        foreach ($errors as $key => $value) {
            if(array_search($key, array_keys($errors)) != 0) {
                $url .= ",";
            }
            $url .= "$key=$value";
        }

        header($url);
        exit();
    }
?>