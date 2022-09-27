<?php
    ini_set('display_errors', 1);

    include_once("database.php");

    $statementString = "SELECT userID, location FROM Experts WHERE adminVerified=1";
    $vars = array();
    $varTypes = "";

    foreach ($_GET as $key => $value) {
        if($key != "adminVerified" && $value == 1) {
            $statementString .= " AND ".$key."=1";
        } else if($key == "expertise") {
            $statementString .= " AND expertise SOUNDS LIKE ?";
            array_push($vars, $value);
            $varTypes .= "s";
        } else if($key == "ages") {
            $ages = explode(",", $value);

            foreach($ages as $age) {
                $statementString .= " AND FIND_IN_SET('$age',ages)>0";
            }
        } else if($key == "orgs") {
            $statementString .= " AND (";
            $orgs = explode(",", $value);

            foreach($orgs as $org) {
                if(substr($statementString, -1) != "(") {
                    $statementString .= " OR ";
                }
                $statementString .= "organisation SOUNDS LIKE '$org'";
            }

            $statementString .= ")";
        }
    }

    $db = new Database();

    $statement = $db->prepareStatement(
        $statementString,
        $varTypes,
        $vars
    );

    $result = $db->sendQuery($statement, array("userID", "location"));
    print_r(json_encode($result));
?>


