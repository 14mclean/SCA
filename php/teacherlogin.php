<?php
    ini_set('display_errors', 1);

    require 'connectDB.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passHash = hash('sha256', $password);
    
    $query = "
    SELECT * from Users WHERE email='$email' AND passwordHash='$passHash'
    ";
    
    $response = $conn->query($query);
    
    if(mysqli_num_rows($response) == 0) {
        echo("Incorrect username or password");
    } else {
        echo("Logged In");
    }
?>