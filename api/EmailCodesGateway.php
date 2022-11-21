<?php

class EmailCodesGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM Email_Code";

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
        $statement = $this->connection->prepare("INSERT INTO Email_Code (user_id, code) VALUES (:user_id, :code)");
        $statement->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
        $statement->bindValue(":code", $data["code"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM Email_Code WHERE user_id=:user_id");
        $statement->bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): int {        
        http_response_code(405);
        header("Allow: GET");
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM Email_Code WHERE userID = :userid");
        $statement.bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}