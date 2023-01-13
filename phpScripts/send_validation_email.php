<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

$data = (array) json_decode(file_get_contents("php://input"), true);
include_once("../api/Database.php");
$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

function code_exists($connection, $code) {
    $statement = $connection->prepare("SELECT * FROM Email_Code WHERE code = :code");
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
    $code = bin2hex(random_bytes(64)); // randomly generate code
} while(code_exists($connection, $code)); // if code clashes repeat

/*$message = "
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Raleway');

    #background {
        background-color: #dddddd;
        width: 100%;
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
    
<div id='background'>
    <div>
        <header>
            <h1>School Citizen Assemblies</h1>
        </header>

        <h2>Email Confirmation</h2>
        <p>Thank you for signing up for the SCA, please click the button below to verify this email address </p>
        <a href=https://schoolcitizenassemblies.org/email-validation.php?code=$code>Verify</a>
    </div>
</div>

";*/

$year = date("Y");
$message = "
<html>
    <head>
        <title>SCA Account Verification Email</title>
    </head>

    <body>
        <table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">
            <tr>
                <td bgcolor=\"#401b57\" style=\"padding: 20px;\">
                    <img src=\"https://www.schoolcitizenassemblies.org/assets/email-logo.png\" alt=\"SCA Logo\" width=\"70%\" style=\"aspect-ratio: 1826/197\"/>
                </td>
            </tr>

            <tr>
                <td bgcolor=\"#eeeeee\"  style=\"padding: 30px 30px 40px 30px;\">
                    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                        <tr>
                            <td>
                                <h2 style=\"font-family: sans-serif;\">Verify Your Account</h2>
                                <p style=\"font-family: sans-serif\">Thanks for signing up for our service! To complete your registration, please click the button below to verify your email address.</p>

                                <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                    <tr>
                                        <td align=\"center\" bgcolor=\"#6b2c91\" style=\"padding: 12px 18px 12px 18px;\">
                                            <a href=\"https://schoolcitizenassemblies.org/email-validation.php?code=$code\" style=\"color: #ffffff; text-decoration: none; font: normal normal 100 16px/16px Arial;\">Verify Account</a> <!-- PHP the verification link -->
                                        </td>
                                    </tr>
                                </table>

                                <p style=\"font-family: sans-serif\">If you have any questions or issues, please contact us at <br> <a href=\"mailto:support@schoolcitizenassemblies.org\">support@schoolcitizenassemblies.org</a>.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td bgcolor=\"#eeeeee\" style=\"padding: 20px 30px 20px 30px;\">
                    <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                        <tr>
                            <td width=\"75%\" style=\"color: #222222; font-family: Arial, sans-serif; font-size: 14px;\">
                            &copy; School Citizen Assemblies. All rights reserved $year<br/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
";

mail( // send email
    $data["email"],
    "School Citizen Assemblies Email Verification",
    $message,
    "From: SCA <hello@schoolcitizenassemblies.org>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n"
);

$statement = $connection->prepare("INSERT INTO Email_Code (user_id,code) VALUES (:user_id, :code)");
$statement->bindValue(":user_id", $data["user_id"]);
$statement->bindValue(":code", $code);
$statement->execute();