<?php

class UserGateway implements Gateway{
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement = $this->connection->query("SELECT * FROM Users");
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): string {
        if(!empty([$data["password"]])) {
            $data["passwordHash"] = hash("sha256", $data["password"]);
        }
        // allow for defaults
        $statement = $this->connection->prepare("INSERT INTO Users (email, passwordHash, emailVerified, userLevel) VALUES (:email, :passwordHash, :emailVerified, :userLevel)");
        $statement->bindValue(":email", $data["email"], PDO::PARAM_STR);
        $statement->bindValue(":passwordHash", $data["passwordHash"], PDO::PARAM_STR);
        $statement->bindValue(":emailVerified", $data["emailVerified"], PDO::PARAM_BOOL);
        $statement->bindValue(":userLevel", $data["userLevel"], PDO::PARAM_STR);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM Users WHERE userID=:userid");
        $statement->bindValue(":userid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_user_details, array $new_user_details): int {
        $statement = $this->connection->prepare(
            "UPDATE Users 
            SET email = :email, passwordHash = :passwordHash, emailVerified = :emailVerified, userLevel = :userLevel
            WHERE userID = :userid;"
            );
        $statement->bindValue(":email", $new_user_details["email"] ?? $current_user_details["email"], PDO::PARAM_STR);
        $statement->bindValue(":passwordHash", $new_user_details["passwordHash"] ?? $current_user_details["passwordHash"], PDO::PARAM_STR);
        $statement->bindValue(":emailVerified", $new_user_details["emailVerified"] ?? $current_user_details["emailVerified"], PDO::PARAM_BOOL);
        $statement->bindValue(":userLevel", $new_user_details["userLevel"] ?? $current_user_details["userLevel"], PDO::PARAM_STR);
        $statement->bindValue(":userid", $current_user_details["userID"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM Users WHERE userID = :userid");
        $statement.bindValue(":userid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}