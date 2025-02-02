<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

include_once("../api/Database.php");

$data = (array) json_decode(file_get_contents("php://input"), true);
$passwordHash = hash("sha256", $data["password"]);

$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

$statement = $connection->prepare("SELECT email_verified FROM User WHERE email = :email AND password_hash = :passwordHash");
$statement->bindValue(":email", $data["email"], PDO::PARAM_STR);
$statement->bindValue(":passwordHash", $passwordHash, PDO::PARAM_STR);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_ASSOC);
if($result == false) {
    $result = [];
}

if(count($result) == 1 || isset($result["userID"])) {
    if( ($result[0]["email_verified"] ?? $result["email_verified"]) == 0) {
        http_response_code(401);
        echo("Email not verified") ;
    } else {
        http_response_code(200);
        echo("Valid");
    }
} else {
    echo("Invalid");
    http_response_code(401);
}
exit();