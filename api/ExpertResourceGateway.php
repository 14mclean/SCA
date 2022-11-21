<?php

class ExpertResourceGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM Expert_Resource";

        $filter = $_GET["filter"] ?? null;

        if($filter != null) {
            $filter = json_decode(base64_decode($filter), TRUE);
            $statement_string .= " WHERE";

            foreach($filter as $column_title => $column_data) {
                $statement_string .= " (";
                
                foreach($column_data["value"] as $value) { // 
                    $statement_string .= $column_title . "=:" . hash("sha1", $value, false) . " " . $column_data["operator"] . " "; 
                }
                $statement_string = substr($statement_string, 0, -strlen($column_data["operator"])-2);
                $statement_string .= ") AND";
            }
            $statement_string = substr($statement_string, 0, -4);
        }
        
        $statement = $this->connection->prepare($statement_string);

        foreach($filter as $column_title => $column_data) {
            foreach($column_data["value"] as $value) {
                $statement->bindValue(":" . hash("sha1", $value, false), $value);
            }
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        $statement = $this->connection->prepare("INSERT INTO Expert_Resource (user_id, name, link, description) VALUES (:user_id, :name, :link, :description)");
        $statement->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
        $statement->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindValue(":link", $data["link"], PDO::PARAM_STR);
        $statement->bindValue(":description", $data["description"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM Expert_Resource WHERE resource_id=:resource_id");
        $statement->bindValue(":resource_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): int {
        $statement = $this->connection->prepare(
            "UPDATE Expert_Resource
            SET name = :name, link = :link, description = :description,
            WHERE resource_id = :resource_id;"
            );
        $statement->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $statement->bindValue(":link", $data["link"], PDO::PARAM_STR);
        $statement->bindValue(":description", $data["description"], PDO::PARAM_STR);
        $statement->bindValue(":resource_id", $data["resource_id"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM Expert_Resource WHERE resource_id = :resource_id");
        $statement->bindValue(":resource_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}