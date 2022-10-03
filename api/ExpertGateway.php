<?php

class ExpertGateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement = $this->connection->query("SELECT * FROM Experts");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        $statemnet->connection->prepare("INSERT INTO Experts (userID, adminVerified) VALUES (:userid, 0)");
        $statement->bindValue(":userid", $data["userID"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }
}