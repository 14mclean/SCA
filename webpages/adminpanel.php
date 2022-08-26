<?php
    session_start();

    if(!isset($_SESSION["userLevel"])) {
        if($_SESSION["userLevel"] != "Admin") {
            header("Location: login.php");
            exit();
        }
    }

    include_once("../phpScripts/database.php");
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
            <?php
                // get userID, email where adminVerified = 0 from USers and experts
                // create table with button to verify (then remove from list)
                // button to block email
                // each row in db is row in table

                /*$db = new Database();
                $statement = $db->prepareStatement();
                $result = $db->sendQuery($statement, array());

                foreach($result as $row) {

                }*/
            ?>
        </section>

        <section>
            <div><h1>Admin Users</h1></div>
            
            <?php
                // get userID, email from users where userLevel = "Admin"
                // button to delete admin users
                // add button to elevate other user to admin

                $db = new Database();
                $statement = $db->prepareStatement(
                    "SELECT email FROM Users WHERE userLevel = 'Admin'",
                    "",
                    array()
                );
                $result = $db->sendQuery($statement, array("email"));

                echo("<table>");
                echo("<tr><td>Email</td><tr>");
                foreach($result as $row) {
                    $email = $row['email'];

                    echo("<tr>");
                    echo("<td> $email </td>");
                    echo("<button>X</button>")
                    echo("</tr>");
                }
                echo("</table>");
            ?>
            <button>+</button>
        </section>

        <section>
            <div><h1>E-Mail Notifications</h1></div>
        </section>
    </body>
</html>