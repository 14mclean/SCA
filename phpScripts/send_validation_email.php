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
    if($result == false) {
        return false;
    } else {
        return true;
    }
}

do {
    $code = bin2hex(random_bytes(128)); // randomly generate code
} while(code_exists($connection, $code)); // if code clashes repeat

$message = "
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Raleway');

    body {
        overflow: hidden;
        background-color: #dddddd;
    }

    div {
        background-color: white;
        width: 800px;
        height: 500px;
        position: relative;
        left: 50%;
        top: 0%;
        transform: translateX(-50%);
    }

    header {
        background-color: #401b57;
        height: 50px;
    }

    header h1 {
        color: white;
        margin-left: 50px;
        line-height: 50px;
        font-family: 'Raleway';
    }

    h2 {
        font-family: 'Open Sans';
        margin-left: 20px;
    }

    p {
        font-family: 'Open Sans';
        margin-left: 20px;
    }

    a {
        background-color: #401b57;
        border-radius: 5px;
        color: white;
        font-family: 'Raleway';
        padding: 8px 20px;
        position: relative;
        left: 25px;
        top: 30px;
        text-decoration: none;
    }

    a:hover {
        background-color: #401b57df;
    }
</style>
    
<div>
    <header>
        <h1>School Citizen Assemblies</h1>
    </header>
    
    <h2>Email Confirmation</h2>
    <p>Thank you for signing up for the SCA, please click the button below to verify this email address </p>
    <a href=https://schoolcitizenassemblies.org/email-validation.php?code=$code>Verify</a>
</div>

";

mail( // send email
    $data["email"],
    "School Citizen Assemblies Email Verification",
    $message,
    "From: SCA <no-reply@schoolcitizenassemblies.org>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n"
);

$statement = $connection->prepare("INSERT INTO EmailCodes (userID,code) VALUES (:userid, :code)");
$statement->bindValue(":userid", $data["userID"]);
$statement->bindValue(":code", $code);
$statement->execute();