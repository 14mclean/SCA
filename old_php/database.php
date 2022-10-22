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
        function sendQuery(mysqli_stmt $stmt): array {
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        private function referenceArray(&$array) {
            foreach($array as $key => &$value) {
                $this->referencedArray[] =& $value;
            }
        }
    }
?>