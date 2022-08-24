<?php
    session_start();

    if(!isset($_SESSION["userLevel"])) {
        if($_SESSION["userLevel"] != "Admin") {
            header("Location: login.php");
            exit();
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Citizen Assemblies</title>
        <link rel="stylesheet" href="../css/adminpanel.css">
    </head>
    <body>
        <section>
            <div><h1>Unapproved Experts</h1></div>
            
        </section>

        <section>
            <div><h1>Admin Users</h1></div>
        </section>

        <section>
            <div><h1>E-Mail Notifications</h1></div>
        </section>
    </body>
</html>