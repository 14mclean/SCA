<?php
    session_start();

    if(!isset($_SESSION["userID"])) {
        header("Location: ../webpages/scahome.html");
        exit();
        
    } else if($_SESSION["userLevel"] == "Teacher") {
        header("Location: ../webpages/scahome.html");
        exit();      
    }

    ini_set("display_errors", 1); // show errors in html (remove after dev)

    include_once("database.php");

    $db = new Database();

    print_r(gettype($_POST["studentOnline"]));
    print_r($_POST["studentOnline"]);

    $statement = $db->prepareStatement(
        "UPDATE Experts SET expertise=?, organisation=?, teacherAdvice=?, projectWork=?, studentOnline=?, studentF2F=? studentResources=?, location=?, ages=? WHERE userID = ?",
        "ssiiiiisi",
        array(
            $_POST["expertise"],
            $_POST["org"],
            intval($_POST["teacherAdvice"]),
            intval($_POST["projectWork"]),
            intval($_POST["studentOnline"]),
            intval($_POST["studentF2F"]),
            intval($_POST["studentResource"]),
            $_POST["location"],
            $_POST["ages"],
            $_SESSION["userID"]
        )
    );

    $db->sendQuery($statement, array());

    //header("Location: ../webpages/directoryresults.php");
    exit();
?>