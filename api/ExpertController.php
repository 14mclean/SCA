<?php

class ExpertController {
    public function __construct(private ExpertGateway $gateway) {
        var_dump($this->$gateway);
    }

    public function process_request(string $method, ?string $id) {
        if($id) {
            $this->process_single_resource($method, $id);
        } else {
            $this->process_collection_resource($method);
        }
    }

    private function process_single_resource($method, $id): void {

    }

    private function process_collection_resource($method): void {
        switch($method) {
            case "GET":
                echo json_encode($this->$gateway->get_all());
                break;
        }
    }
}