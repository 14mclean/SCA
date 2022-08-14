<?php
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
        "charLengthError" = false,
        "numError" = false,
        "uppercaseError" = false,
        "lowercaseError" = false,
    ];
    
    if(strlen($password) < 8) {
        $errors["charLengthError"] = true;
    } else if(!$number) {
        $errors["numError"] = true;
    } else if(!$uppercase) {
        $errors["uppercaseError"] = true;
    } else if(!$lowercase) {
        $errors["lowercaseError"] = true;
    }
    
    if(isError($errors)) {
        $passHash = hash('sha256', $password);
        $query = "INSERT INTO Users (email, passwordHash) VALUES ('$email','$passHash');";
        $result = $conn->query($query);

        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["loginType"] = "teacher";
        header("Location: ../directoryresults.php");
        exit();
    } else {
        $url = "Location: ../usersignup.php?"

        foreach ($errors as $key => $value) {
            if(key($key $errors) != 0) {
                $url .= ",";
            }
            $url .= "$key=$value";
        }

        header($url);
        exit();
    }

    function isError($errors) {
        foreach ($errors as $key => $value) {
            if($value) {
                return true;
            }
        }
    }
?>