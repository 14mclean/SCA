<?php

class ExpertGateway implements Gateway {
    private PDO $connection;

    public function __construct(Database $db) {
        $this->connection = $db->get_connection();
    }

    public function get_all(): array {
        $statement_string = "SELECT * FROM Expert";

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
        var_dump($statement_string);
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
        $statement = $this->connection->prepare("INSERT INTO Expert (user_id, admin_verified) VALUES (:user_id, 0)");
        $statement->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id): array | false {
        $statement = $this->connection->prepare("SELECT * FROM Expert WHERE user_id=:user_id");
        $statement->bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current_expert_details, array $new_expert_details): INT {      
        $statement = $this->connection->prepare("
            UPDATE Expert
            SET name = :name,
            admin_verified = :admin_verified,
            about = :about,
            organisation = :organisation,
            location = :location,
            job_title = :job_title,
            does_teacher_advice = :does_teacher_advice,
            does_project_work = :does_project_work,
            does_student_online = :does_student_online,
            does_student_f2f = :does_student_f2f,
            does_student_resource = :does_student_resource,
            does_ks1 = :does_ks1,
            does_ks2 = :does_ks2,
            does_ks3 = :does_ks3,
            does_ks4 = :does_ks4,
            does_ks5 = :does_ks5
            WHERE user_id = :user_id;
        ");

        $statement->bindValue(":name", $new_expert_details["name"] ?? $current_expert_details["name"], PDO::PARAM_STR);
        $statement->bindValue(":admin_verified", $new_expert_details["admin_verified"] ?? $current_expert_details["admin_verified"], PDO::PARAM_INT);
        $statement->bindValue(":about", $new_expert_details["about"] ?? $current_expert_details["about"], PDO::PARAM_STR);
        $statement->bindValue(":organisation", $new_expert_details["organisation"] ?? $current_expert_details["organisation"], PDO::PARAM_STR);
        $statement->bindValue(":location", $new_expert_details["location"] ?? $current_expert_details["location"], PDO::PARAM_STR);
        $statement->bindValue(":job_title", $new_expert_details["job_title"] ?? $current_expert_details["job_title"], PDO::PARAM_STR);
        $statement->bindValue(":does_teacher_advice", $new_expert_details["does_teacher_advice"] ?? $current_expert_details["does_teacher_advice"], PDO::PARAM_INT);
        $statement->bindValue(":does_project_work", $new_expert_details["does_project_work"] ?? $current_expert_details["does_project_work"], PDO::PARAM_INT);
        $statement->bindValue(":does_student_online", $new_expert_details["does_student_online"] ?? $current_expert_details["does_student_online"], PDO::PARAM_INT);
        $statement->bindValue(":does_student_f2f", $new_expert_details["does_student_f2f"] ?? $current_expert_details["does_student_f2f"], PDO::PARAM_INT);
        $statement->bindValue(":does_student_resource", $new_expert_details["does_student_resource"] ?? $current_expert_details["does_student_resource"], PDO::PARAM_INT);
        $statement->bindValue(":does_ks1", $new_expert_details["does_ks1"] ?? $current_expert_details["does_ks1"], PDO::PARAM_INT);
        $statement->bindValue(":does_ks2", $new_expert_details["does_ks2"] ?? $current_expert_details["does_ks2"], PDO::PARAM_INT);
        $statement->bindValue(":does_ks3", $new_expert_details["does_ks3"] ?? $current_expert_details["does_ks3"], PDO::PARAM_INT);
        $statement->bindValue(":does_ks4", $new_expert_details["does_ks4"] ?? $current_expert_details["does_ks4"], PDO::PARAM_INT);
        $statement->bindValue(":does_ks5", $new_expert_details["does_ks5"] ?? $current_expert_details["does_ks5"], PDO::PARAM_INT);
        $statement->bindValue(":user_id", $new_expert_details["user_id"] ?? $current_expert_details["user_id"], PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id): INT {
        $statement = $this->connection->prepare("DELETE FROM Expert WHERE user_id = :user_id");
        $statement.bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}