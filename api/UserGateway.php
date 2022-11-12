<?php

class UserGateway implements Gateway{
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM User";

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
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result == false) {
            return array();
        } else {
            return $result;
        }
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