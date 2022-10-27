<?php

class EmailCodesGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM EmailCodes";

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
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        $statement = $this->connection->prepare("INSERT INTO EmailCode (userID, code) VALUES (:userid, :code)");
        $statement->bindValue(":userid", $data["userID"], PDO::PARAM_INT);
        $statement->bindValue(":code", $data["code"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM EmailCode WHERE userID=:userid");
        $statement->bindValue(":userid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): int {        
        http_response_code(405);
        header("Allow: GET");
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM EmailCodes WHERE userID = :userid");
        $statement.bindValue(":userid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}