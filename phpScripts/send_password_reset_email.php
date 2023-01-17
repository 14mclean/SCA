<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

$email = $_POST["email"];

include_once("../api/Database.php");
$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

$statement = $connection->prepare("SELECT user_id FROM User WHERE email = :email");
$statement->bindValue(":email", $email, PDO::PARAM_STR);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$user_id = $result["user_id"];

function code_exists($connection, $code) {
    $statement = $connection->prepare("SELECT * FROM Password_Reset_Code WHERE code = :code");
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

// add code to db
$statement = $connection->prepare("INSERT INTO `Password_Reset_Code`(`user_id`, `code`, `entry_date`) VALUES (:user_id, :code, :entry_date)");
$statement->bindValue(":user_id", $user_id);
$statement->bindValue(":code", $code);
$statement->bindValue(":entry_date", date('Y-m-d H:i:s'));
$statement->execute();

// send create email with code link to password reset
$year = date("Y");
$message = "
<html>
<head>
    <title>SCA Password Reset</title>
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
                            <h2 style=\"font-family: sans-serif;\">Reset Your Password</h2>
                            <p style=\"font-family: sans-serif\">We received a request to reset the password for your account. If you did not make this request you can ignore this email.</p>

                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                <tr>
                                    <td align=\"center\" bgcolor=\"#6b2c91\" style=\"padding: 12px 18px 12px 18px;\">
                                        <a href=\"https://schoolcitizenassemblies.org/password-reset.php?code=$code\" style=\"color: #ffffff; text-decoration: none; font: normal normal 100 16px/16px Arial;\">Reset Password</a> <!-- PHP the verification link -->
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

mail(
    $email,
    "Password Reset",
    $message,
    "From: SCA <sca@schoolcitizenassemblies.org>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n"
);

header("/");
exit();