<?php
    ini_set('display_errors', 1);

    class Database {
        public $connection;

        function __construct() {
            $this->connection = new mysqli('localhost', 'mwd3iqjaesdr', 'cPanMT3', 'SchoolCitizenAssemblies');
        }

        function prepareStatement(string $statement, string $paramTypes, array $params):mysqli_stmt {
            $query = $this->connection->prepare($statement);

            if($paramTypes != "") {
                $this->referencedArray = array();
                $this->referenceArray($params);
                array_unshift($this->referencedArray, $paramTypes);
                call_user_func_array(array(&$query, "bind_param"), $this->referencedArray);
                unset($this->referencedArray);
            }
            
            return $query;
        }

        /**
         * query - mysqli statement with parameters already bound
         */
        function sendQuery(mysqli_stmt $query, array $resultFields): array {
            // execute query and get mysqli_result
            try {
                $query->execute();
            } catch(mysqli_sql_exception $e) {
                error_log(print_r($e, true));
            }
            $query->store_result();

            if($query->num_rows > 0) {
                // make result 2d array of result
                $result = array();
                $tempRow = array();

                for($j = 0; $j < $query->field_count; $j++) {
                    $tempRow[$resultFields[$j]] = NULL;
                }

                $this->referencedArray = array();
                $this->referenceArray($tempRow);
                call_user_func_array(array(&$query, 'bind_result'), $this->referencedArray);
                unset($this->referencedArray);

                for($i = 0; $i < $query->num_rows; $i++) {
                    $query->fetch();
                    $row = $tempRow;
                    print_r(&$tempRow);
                    print_r(&$row);
                    array_push($result, $row);
                }
            } else {
                $result = array();
            }
            
            return $result;
        }

        private function referenceArray(&$array) {
            foreach($array as $key => &$value) {
                $this->referencedArray[] =& $value;
            }
        }
    }
?>