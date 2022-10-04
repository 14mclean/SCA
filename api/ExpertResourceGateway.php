<?php

class ExpertResourceGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement = $this->connection->query("SELECT * FROM ExpertResources");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        $statemnet->connection->prepare("INSERT INTO ExpertResources (userID, name, link) VALUES (:userid, :name, :link)");
        $statement->bindValue(":userid", $data["userID"], PDO::PARAM_INT);
        $statement->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindValue(":link", $data["link"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM ExpertResources WHERE resourceID=:resourceid");
        $statement->bindValue(":resourceid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): int {
        $statement = $this->connection->prepare(
            "UPDATE Experts 
            SET userID = :userid, name = :name, link = :link
            WHERE resourceID = :resourceid;"
            );
        $statement->bindValue(":userid", $data["userID"], PDO::PARAM_INT);
        $statement->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindValue(":link", $data["link"], PDO::PARAM_STR);
        $statement->bindValue(":resourceid", $data["resourceid"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM ExpertResources WHERE resourceID = :resourceid");
        $statement.bindValue(":resourceid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}