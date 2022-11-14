<?php

class ExpertiseGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM Expertise";

        if(count($_GET) > 0) {
            $condition_string = " WHERE";
            foreach($_GET as $column => $value) {
                $condition_string .= " $column = :$column AND";
            }
            $statement_string .= substr($condition_string, 0, -3);
        }

        $statement = $this->connection->prepare($statement_string);

        foreach($_GET as $column => $value) {
            $statement->bindValue(":$column", $value);
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        $statement = $this->connection->prepare("INSERT INTO Expertise (user_id, expertise) VALUES (:user_id, :expertise)");
        $statement->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
        $statement->bindValue(":expertise", $data["user_id"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM Expertise WHERE expertise_instance_id=:expertise_instance_id");
        $statement->bindValue(":expertise_instance_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): int {      
        $statement = $this->connection->prepare("
            UPDATE Expert
            SET expertise=:expertise, user_id=:user_id
            WHERE expertise_instance_id = :expertise_instance_id;
        ");

        $statement->bindValue(":expertise", $new_expert_details["expertise"] ?? $current_expert_details["expertise"], PDO::PARAM_STR);
        $statement->bindValue(":user_id", $new_expert_details["user_id"] ?? $current_expert_details["user_id"], PDO::PARAM_INT);
        $statement->bindValue(":expertise_instance_id", $new_expert_details["expertise_instance_id"] ?? $current_expert_details["expertise_instance_id"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }
}