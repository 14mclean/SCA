<?php

ini_set("display_errors", 1); // show errors in html (remove after dev)

$code = "aa711b34a92e4712a2eb0b3686c6a9b6e0e200af3c7fb2977bdbd11eb648c422cc2496cab3b8e44cc19fa4e4421d89ffa7d160d546bae47bd27d326b4c1bc14b";
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
    "s.dick@chesterzoo.org",
    "School Citizen Assemblies Email Verification",
    $message,
    "From: SCA <hello@schoolcitizenassemblies.org>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n"
);