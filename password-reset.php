<?php

include_once("api/Database.php");

$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

$code = $_GET["code"];

// check if code is still valid
$statement = $connection->prepare("SELECT user_id,entry_date FROM Password_Reset_Code WHERE code = :code");
$statement->bindValue(":code", $code);
$statement->execute();
$result = $statement->fetch(PDO::FETCH_ASSOC);
$error = "";

if($result) {
    $expiry_datetime = date_create($result["entry_date"]);
    $expiry_datetime->modify("+1 day");

    $user_id = $result["user_id"];

    if($expiry_datetime > date('Y-m-d H:i:s')) {
        $error = "Password reset link expired, if you still need to change your password click <a href=\"forgot-password.html\">Here</a>";
    }

    // delete code
    $statement = $connection->prepare("DELETE FROM Password_Reset_Code WHERE code=:code");
    $statement->bindValue(":code", $code, PDO::PARAM_STR);
    $statement->execute();
} else {
    $error = "This password reset link does not exist";
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Reset - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/password-reset.css">
    </head>

    <body>
        <header>
            <h1><a href="/">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div class="form_container">
                <h1>Password Reset</h1>

                <p id="descriptor">Enter a new password for your account</p>

                <form action="phpScripts/reset_password.php" method="POST">
                    <?php if($error = ""): ?>

                        <input id="password_input" name="password" type="password" placeholder="Password" autocomplete="new-password" required>
                        <img class="visibility-eye" id="initial" src="assets/noEye.png">

                        <input id="confirm_password_input" name="password" type="password" placeholder="Confirm Password" autocomplete="new-password" required>
                        <img class="visibility-eye" id="confirm" src="assets/noEye.png">
                        
                        <button type="submit">Reset</button>

                    <?php else: ?>

                        <p>
                            <?php echo $error ?>
                        </p>

                    <!-- TODO: show errors -->
                </form>
            </div>
        </main>

        <script src="javascript/debounce.js"></script>
        <script src="javascript/valid_password.js"></script>
        <script src="javascript/password-reset.js"></script>
    </body>
</html>