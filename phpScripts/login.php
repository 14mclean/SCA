<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

include_once("../api/Database.php");

$data = (array) json_decode(file_get_contents("php://input"), true);
var_dump($_POST);
var_dump($data);
$passHash = hash("sha256", $data["password"]); // TODO change to POST

$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();
$statement = $connection->prepare("SELECT userID,emailverified,userLevel FROM Users WHERE email = :email AND passwordHash = :passwordHash");
$statement->bindValue(":email", $data["email"], PDO::PARAM_STR);
$statement->bindValue(":passwordHash", $passHash, PDO::PARAM_STR);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);

if($result == false) {
    $result = [];
}

if(count($result) == 1 || isset($result["userID"])) {
    // check email validation


    session_start();
    $_SESSION["userID"] = $result[0]["userID"] ?? $result["userID"];
    $_SESSION["userLevel"] = $result[0]["userLevel"]  ?? $result["userLevel"];
    header("Location: ../directory.php"); // redirect to directory
} else {
    //header("Location: ../meet-the-experts.php");
}
exit();