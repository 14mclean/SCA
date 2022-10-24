<?php

class ExpertGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM Experts";

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
        // be able to insert more than userid
        $statement = $this->connection->prepare("INSERT INTO Experts (userID, adminVerified) VALUES (:userid, 0)");
        $statement->bindValue(":userid", $data["userID"], PDO::PARAM_INT);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM Experts WHERE userID=:userid");
        $statement->bindValue(":userid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): int {        
        $statement = $this->connection->prepare(
            "UPDATE Experts 
            SET adminVerified = :adminVerified, organisation = :organisation, ages = :ages, expertise = :expertise,
            teacherAdvice = :teacherAdvice, projectWork = :projectWork, studentOnline = :studentOnline, studentF2F = :studentF2F,
            studentResources = :studentResources, location = :location
            WHERE userID = :userid;"
            );
        $statement->bindValue(":adminVerified", $new_expert_details["adminVerified"] ?? $current_expert_details["adminVerified"], PDO::PARAM_STR);
        $statement->bindValue(":organisation", $new_expert_details["organisation"] ?? $current_expert_details["organisation"], PDO::PARAM_STR);
        $statement->bindValue(":ages", $new_expert_details["ages"] ?? $current_expert_details["ages"], PDO::PARAM_STR);
        $statement->bindValue(":expertise", $new_expert_details["expertise"] ?? $current_expert_details["expertise"], PDO::PARAM_STR);
        $statement->bindValue(":teacherAdvice", $new_expert_details["teacherAdvice"] ?? $current_expert_details["teacherAdvice"], PDO::PARAM_BOOL);
        $statement->bindValue(":projectWork", $new_expert_details["projectWork"] ?? $current_expert_details["projectWork"], PDO::PARAM_BOOL);
        $statement->bindValue(":studentOnline", $new_expert_details["studentOnline"] ?? $current_expert_details["studentOnline"], PDO::PARAM_BOOL);
        $statement->bindValue(":studentF2F", $new_expert_details["studentF2F"] ?? $current_expert_details["studentF2F"], PDO::PARAM_BOOL);
        $statement->bindValue(":studentResources", $new_expert_details["studentResources"] ?? $current_expert_details["studentResources"]);
        $statement->bindValue(":location", $new_expert_details["location"] ?? $current_expert_details["location"], PDO::PARAM_STR);
        $statement->bindValue(":userid", $current_expert_details["userID"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id): int {
        $statement = $this->connection->prepare("DELETE FROM Experts WHERE userID = :userid");
        $statement.bindValue(":userid", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}