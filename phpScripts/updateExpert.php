<?php
    session_start();

    if(!isset($_SESSION["userID"])) {
        header("Location: ../webpages/scahome.html");
        exit();
        
    } else if($_SESSION["userLevel"] == "Teacher") {
        header("Location: ../webpages/scahome.html");
        exit();      
    }

    /*
        Array
        (
            [expertise] => 
            [org] => Test & Co
            [teacherAdvice] => true
            [projectWork] => true
            [studentOnline] => true
            [studentF2F] => true
            [studentResources] => true
            [location] => 
            [ages] => KS1,KS2,KS3,KS4,KS5
        )
    */

    ini_set("display_errors", 1); // show errors in html (remove after dev)

    include_once("database.php");

    $db = new Database();

    print_r(gettype($_POST["studentOnline"]));
    print_r($_POST["studentOnline"]);

    $statement = $db->prepareStatement(
        "UPDATE Experts SET expertise=?, organisation=?, teacherAdvice=?, projectWork=?, studentOnline=?, studentF2F=? studentResources=?, location=?, ages=? WHERE userID = ?",
        "ssiiiiisi", // is a set of type string??
        array(
            $_POST["expertise"],
            $_POST["org"],
            // teacherAdvice
            // projectWork
            // studentOnline
            // studentF2F
            // studentResource
            $_POST["location"],
            $_POST["ages"],     // check for correct formatting
            $_SESSION["userID"]
        )
    );

    //$db->sendQuery($statement, array());

    //header("Location: ../webpages/directoryresults.php");
    exit();
?>