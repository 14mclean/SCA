<?php
    ini_set("display_errors", 1); // show errors in html (remove after dev)

    include_once("../api/Database.php");

    $passHash = hash("sha256", $_GET["password"]);

    $db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
    $connection = $db->get_connection();
    $statement = $connection->prepare("SELECT userID,emailverified,userLevel FROM Users WHERE email = :email AND passwordHash = :passwordHash");
    $statement->bindValue(":email", $_GET["email"], PDO::PARAM_STR);
    $statement->bindValue(":passwordHash", $passHash, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    var_dump($result);

    if(count($result) == 1 || isset($result["userID"])) {
        session_start();
        var_dump($result[0]["userID"]);
        var_dump($result[0]["userLevel"]);
        $_SESSION["userID"] = $result[0]["userID"];
        $_SESSION["userLevel"] = $result[0]["userLevel"];
        //header("Location: ../directory.php"); // redirect to directory
    } else {
        header("Location: ../meet-the-experts.php");
    }
    exit();
?>