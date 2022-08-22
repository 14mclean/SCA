<?php
    ini_set('display_errors', 1);

    class Database {
        public $connection;

        function __construct() {
            $this->connection = new mysqli('localhost', 'mwd3iqjaesdr', 'cPanMT3', 'SchoolCitizenAssemblies');
        }

        function prepareStatement(string $statement, string $paramTypes, array $params):mysqli_stmt {
            $query = $this->connection->prepare($statement);
            var_dump($this->referenceArray($params));
            echo("<br>");
            call_user_func_array(array(&$query, "bind_param"), $this->referenceArray($params));

            return $query;
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

        private static function referenceArray(array $array): array {
            $result = array();
            var_dump($array);
            echo("<br>");

            foreach($array as $key=>$value) {
                $result[$key] = &$value;
            }

            return $result;
        }
    }
?>