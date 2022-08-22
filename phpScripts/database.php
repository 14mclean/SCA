<?php

    class Database {
        public readonly $connection;

        function __construct() {
            $this->connection = new mysqli('localhost', 'mwd3iqjaesdr', 'cPanMT3', 'SchoolCitizenAssemblies');
        }


        /**
         * query - mysqli statement with parameters already bound
         */
        function getResult(mysqli_stmt $query, array $resultFields): array {
            $query->execute();
            $query->store_result();

            $result = array();

            for($i = 0; $i < $query->num_rows; $i++) {
                $row = array();
                for($j = 0; $j < $query->field_count; $j++) {

                }
            }
        }
    }

?>