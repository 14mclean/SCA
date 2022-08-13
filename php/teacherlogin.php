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
        header("Location: ../userlogin.php?loginError=true");
        exit();
    } else {
        if(isset(session_id())) {
            session_destroy();
        }
        
        session_start();
        $_SESSION["email"] = $email;
        echo session_id();
        //header("Location: ../directoryresults.php");
        //exit();
    }
?>