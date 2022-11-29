<?php

class UserGateway implements Gateway{
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM User";

        $filter = $_GET["filter"] ?? null;

        if($filter != null) {
            $filter = json_decode(base64_decode($filter), TRUE);
            $statement_string .= " WHERE";

            foreach($filter as $column_title => $column_data) {
                if(!count($column_data["value"])) {
                    continue;
                }

                $statement_string .= " (";

                foreach($column_data["value"] as $key => $value) {
                    $statement_string .= $column_title . "=:" . hash("sha1", $column_title.$value.$key, false) . " " . $column_data["operator"] . " "; 
                }
                $statement_string = substr($statement_string, 0, -strlen($column_data["operator"])-2);
                $statement_string .= ") AND";
            }
            $statement_string = substr($statement_string, 0, -4);
        }
        
        $statement = $this->connection->prepare($statement_string);

        foreach($filter as $column_title => $column_data) {
            foreach($column_data["value"] as $key => $value) {
                $statement->bindValue(":" . hash("sha1", $column_title.$value.$key, false), $value);
            }
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        if(!empty([$data["password"]])) {
            $data["password_hash"] = hash("sha256", $data["password"]);
        }
        $statement = $this->connection->prepare("INSERT INTO User (email, password_hash, email_verified, user_level) VALUES (:email, :password_hash, :email_verified, :user_level)");
        $statement->bindValue(":email", $data["email"], PDO::PARAM_STR);
        $statement->bindValue(":password_hash", $data["password_hash"], PDO::PARAM_STR);
        $statement->bindValue(":email_verified", $data["email_verified"], PDO::PARAM_BOOL);
        $statement->bindValue(":user_level", $data["user_level"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM User WHERE user_id=:user_id");
        $statement->bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_user_details, array $new_user_details): int {
        $statement = $this->connection->prepare(
            "UPDATE User 
            SET email = :email, password_hash = :password_hash, email_verified = :email_verified, user_level = :user_level
            WHERE user_id = :user_id;"
            );
        $statement->bindValue(":email", $new_user_details["email"] ?? $current_user_details["email"], PDO::PARAM_STR);
        $statement->bindValue(":password_hash", $new_user_details["password_hash"] ?? $current_user_details["password_hash"], PDO::PARAM_STR);
        $statement->bindValue(":email_verified", $new_user_details["email_verified"] ?? $current_user_details["email_verified"], PDO::PARAM_BOOL);
        $statement->bindValue(":user_level", $new_user_details["user_level"] ?? $current_user_details["user_level"], PDO::PARAM_STR);
        $statement->bindValue(":user_id", $current_user_details["user_id"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM User WHERE user_id = :user_id");
        $statement.bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}