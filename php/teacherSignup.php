<?php
    require 'connectDB.php';
    
    $errors = array();
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // check for already used email
    $existingEmailQuery = prepare("SELECT EXISTS(SELECT * from Users WHERE email='$email');");
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
    
    if(strlen($password) < 8) {
        array_push($errors, 'Password must be at least 8 characters long');
    } else if(!$number) {
        array_push($errors, 'Password must include a number');
    } else if(!$uppercase) {
        array_push($errors, 'Password must include an uppercase letter');
    } else if(!$lowercase) {
        array_push($errors, 'Password must include an lowercase letter');
    }
    
    if(count($errors) == 0) {
        $passHash = hash('sha256', $password);
        $query = prepare("INSERT INTO Users (email, passwordHash) VALUES ('$email','$passHash');");
        
        $result = $conn->query($query);
        echo($result);
    } else {
        print_r($errors);
    }
?>