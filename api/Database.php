<?php

class Database {
    public function __construct(
        private string $host,
        private string $name,
        private string $username,
        private string $password) 
        {}

    public function get_connection(): PDO {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";
        $pdo = new PDO(
            $dsn,
            $this->username,
            $this->password,
            [PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_STRINGIFY_FETCHES => false]
        );
        $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, ["LoggedPDOStatement", [$pdo]]);
        return $pdo;
    }
}

class LoggedPDOStatement extends PDOStatement
{
    protected function __construct(protected PDO $pdo) {}

    public function execute(?array $params = null): bool {
        // time and execute the query
        $start_time = microtime(true);
        $result = parent::execute($params);
        $end_time = microtime(true);

        // Log the query to a table
        $timestamp = date('Y-m-d H:i:s');
        $query_body = $this->queryString;
        $execute_length = $end_time - $start_time;
        $debug_output = parent::debugDumpParams();

        $this->pdo->exec("INSERT INTO Query_Log (timestamp, query_body, query_execute_length, debug_output) VALUES ('$timestamp', '$query_body', $execute_length, '$debug_output')");

        return $result;
    }
}