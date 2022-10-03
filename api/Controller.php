<?php

abstract class Controller {
    public function __construct(private Gateway $gateway, private string $resource_name) {}

    public function process_request(string $method, ?string $id): void {
        if($id) {
            $this->process_single_resource($method, $id);
        } else {
            $this->process_collection_resource($method);
        }
    }

    protected function process_single_resource(string $method, string $id): void {
        $resource = $this->gateway->get($id);

        if(!$expert) {
            http_response_code(404);
            echo json_encode(["message" => "$this->resource_name not found"]);
            return;
        }

        switch($method) {
            case "GET":
                echo json_encode($resource);
                break;
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->get_validation_errors($data, false);

                if(!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows_affected = $this->gateway->update($expert, $data);

                echo json_encode([
                    "message" => "$this->resource_name $id updated",
                    "rows" => $rows_affected
                ]);

                break;
            case "DELETE":
                $rows_affected = $this->gateway->delete($id);
                echo json_encode([
                    "message" => "$this->resource_name $id deleted",
                    "rows" => $rows_affected
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }

    protected function process_collection_resource(string $method): void {
        switch($method) {
            case "GET":
                echo json_encode($this->gateway->get_all());
                break;
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->get_validation_errors($data);

                if(!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "$this->resource_name added",
                    "id" => $id
                ]);

                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    protected abstract function get_validation_errors(array $data, bool $is_new = true): array;
}