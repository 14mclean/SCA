<?php

class ExpertGateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement = $this->connection->prepare("SELECT * FROM Experts");
        $statement->execute();
        return $statement->fetchAll();
    }
}