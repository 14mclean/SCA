<?php

include_once("api/Database.php");

$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

$code = $_GET["code"];

// get userID for code
$statement = $connection->prepare("SELECT * FROM Email_Code WHERE code = :code");
$statement->bindValue(":code", $code, PDO::PARAM_STR);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);
$user_id = $result[0]["user_id"] ?? $result["user_id"];

// get userLevel for userID
$statement = $connection->prepare("SELECT * FROM User WHERE user_id = :user_id");
$statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);
$user_level = $result[0]["user_level"] ?? $result["user_level"];

// update user to email verified
$statement = $connection->prepare("UPDATE User SET email_verified=1 WHERE user_id=:user_id");
$statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$statement->execute();

// delete code
$statement = $connection->prepare("DELETE FROM Email_Code WHERE code=:code");
$statement->bindValue(":code", $code, PDO::PARAM_STR);
$statement->execute();

// start session and add userID & userLevel to session
session_start();
$_SESSION["user_id"] = $user_id;
$_SESSION["user_level"] = $user_level;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Validation - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/email-validation.css">
    </head>

    <body>
        <header>
            <h1><a href="home.php">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div id="container">
                <h1>Email has been Verified</h1>
            </div>
        </main>
    </body>
</html>