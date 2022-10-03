<?php

class ExpertController {
    public function __construct(private ExpertGateway $gateway) {}

    public function process_request(string $method, ?string $id) {
        if($id) {
            $this->process_single_resource($method, $id);
        } else {
            $this->process_collection_resource($method);
        }
    }

    private function process_single_resource(string $method, string $id): void {

    }

    private function process_collection_resource(string $method): void {
        switch($method) {
            case "GET":
                echo json_encode($this->gateway->get_all());
                break;
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $id = $this->gateway->create($data);

                echo json_encode([
                    "message" => "Expert added",
                    "id" => $id
                ]);

                break;
        }
    }
}