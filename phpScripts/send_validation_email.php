<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

$data = (array) json_decode(file_get_contents("php://input"), true);
include_once("../api/Database.php");
$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

function code_exists($connection, $code) {
    $statement = $connection->prepare("SELECT * FROM EmailCodes WHERE code = :code");
    $statement->bindValue(":code", $code, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return count($result) > 0;
}

do {
    $code = bin2hex(random_bytes(128)); // randomly generate code
} while(code_exists($connection, $code)); // if code clashes repeat

mail( // send email
    $data["email"],
    "School Citizen Assemblies Email Verification",
    "Click this link: schoolcitizenassemblies/email-validation?code=".$code,
    "From: no-reply@schoolcitizenassemblies.org"
);

$statement = $connection->prepare("INSERT INTO EmailCodes (userID,code) VALUES (:userid, :code)");
$statement->bindValue(":userid", $data["userID"]); // TODO get userid
$statement->bindValue(":code", $code);
$statement->execute();