<?php

class ExpertiseGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM Expertise";

        $filter = $_GET["filter"] ?? null;

        if($filter != null) {
            $filter = json_decode(base64_decode($filter), TRUE);
            $statement_string .= " WHERE";

            foreach($filter as $column_title => $column_data) {
                if(!count($column_data["value"])) {
                    continue;
                }

                $statement_string .= " (";

                foreach($column_data["value"] as $value) {
                    $statement_string .= $column_title . "=:" . hash("sha1", $column_title.$value, false) . " " . $column_data["operator"] . " "; 
                }
                $statement_string = substr($statement_string, 0, -strlen($column_data["operator"])-2);
                $statement_string .= ") AND";
            }
            $statement_string = substr($statement_string, 0, -4);
        }
        
        $statement = $this->connection->prepare($statement_string);

        foreach($filter as $column_title => $column_data) {
            foreach($column_data["value"] as $value) {
                $statement->bindValue(":" . hash("sha1", $column_title.$value, false), $value);
            }
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

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM Expertise WHERE expertise_instance_id = :expertise_instance_id");
        $statement.bindValue(":expertise_instance_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}