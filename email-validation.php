<?php

include_once("api/Database.php");

$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

$code = $_GET["code"];

// get userID for code
$statement = $connection->prepare("SELECT * FROM EmailCodes WHERE code = :code");
$statement->bindValue(":code", $code, PDO::PARAM_STR);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);
$userID = $result[0]["userID"] ?? $result["userID"];

// get userLevel for userID
$statement = $connection->prepare("SELECT * FROM Users WHERE userID = :userid");
$statement->bindValue(":userid", $userID, PDO::PARAM_INT);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);
$userLevel = $result[0]["userLevel"] ?? $result["userLevel"];

// update user to email verified
$statement = $connection->prepare("UPDATE Users SET emailVerified=1 WHERE userID=:userid");
$statement->bindValue(":userid", $userID, PDO::PARAM_INT);
$statement->execute();

// delete code
$statement = $connection->prepare("DELETE FROM EmailCodes WHERE code=:code");
$statement->bindValue(":code", $code, PDO::PARAM_STR);
$statement->execute();

// start session and add userID & userLevel to session
session_start();
$_SESSION["userID"] = $userID;
$_SESSION["userLevel"] = $userLevel;

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
            <h1><a href="home.html">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div id="container">
                <h1>email verified</h1>
            </div>
        </main>
    </body>
</html>