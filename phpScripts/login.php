<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

include_once("../api/Database.php");

$passHash = hash("sha256", $_POST["password"]);

$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();
$statement = $connection->prepare("SELECT user_id,email_verified,user_level FROM User WHERE email = :email AND password_hash = :password_hash");
$statement->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
$statement->bindValue(":password_hash", $passHash, PDO::PARAM_STR);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);

if($result == false) {
    $result = [];
}

if( ($result[0]["email_verified"] ?? $result["email_verified"]) == 0) {
    // show email validation
    print_r("No email validation");
} else if(count($result) == 1 || isset($result["user_id"])) {
    session_start();
    $_SESSION["user_id"] = $result[0]["user_id"] ?? $result["user_id"];
    $_SESSION["user_level"] = $result[0]["user_level"]  ?? $result["user_level"];
    header("Location: ../directory.php"); // redirect to directory
} else {
    //header("Location: ../meet-the-experts.php");
}
exit();