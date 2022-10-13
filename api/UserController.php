<?php

class UserController extends Controller {
    public function __construct(UserGateway $gateway) {
        parent::__construct($gateway, "User");
    }

    protected function get_validation_errors(array $data, bool $is_new = true): array {
        $errors = [];

        if(!empty([$data["password"]])) {
            $data["passwordHash"] = hash("sha256", $data["password"]);
        }

        // do field validation
            // if new different validation
            // else

        return $errors;
    }
}