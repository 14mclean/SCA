<?php
    ini_set('display_errors', 1);

    require 'connectDB.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passHash = hash('sha256', $password);
    
    $query = $conn -> prepare("
    SELECT * from Users WHERE email='$email' AND passwordHash='$passHash'
    ");
    
    $response = $conn->query($query);
    
    if(mysqli_num_rows($response) == 0) {
        $_POST['loginError'] = "Incorrect Email or Password";
        header("Location: userlogin.html");
        exit();
    } else {
        echo("Logged In");
        session_start();
        $_SESSION['email'] = $email;
    }
?>