<?php
    ini_set('display_errors', 1);

    class Database {
        public $connection;

        function __construct() {
            $this->connection = new mysqli('localhost', 'mwd3iqjaesdr', 'cPanMT3', 'SchoolCitizenAssemblies');
        }


        /**
         * query - mysqli statement with parameters already bound
         */
        function getResult(mysqli_stmt $query, array $resultFields): array {
            // execute query and get mysqli_result
            $query->execute();
            $query->store_result();

            // make result 2d array of result
            $result = array();
            $tempRow = array();

            for($j = 0; $j < $query->field_count; $j++) {
                $tempRow[$resultFields[$j]] = NULL;
            }

            call_user_func_array(array(&$query, 'bind_result'), $this->referenceArray($tempRow));

            for($i = 0; $i < $query->num_rows; $i++) {
                $query->fetch();
                array_push($result, $tempRow);
            }

            $query->close();
            return $result;
        }

        function temp() {
            $statement = $conn->prepare(
                "SELECT userID,emailverified,userLevel FROM Users WHERE email = ? AND passwordHash = ?"     
            ); // prepare universal statement to get for user fitting GET variables
            $statement->bind_param("ss", $_POST["email"], $passHash);
            $statement->execute();
            $statement->store_result();

            $temp = array();
            for($i = 0; $i < $statement->num_rows(); $i++) {
                $statement->bind_result($userID, $emailVerified, $level);
                $statement->fetch();
                array_push($temp, array($userID, $emailVerified, $level) );
            }
            
        }

        private static function referenceArray(array $array): array {
            $result = array();

            foreach($array as &$value) {
                array_push($result, $value);
            }

            return $result;
        }
    }
?>