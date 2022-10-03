<?php

class UserController extends Controller {
    public function __construct(ResourceGateway $gateway) {
        parent::__construct($gateway, "User");
    }

    private function get_validation_errors(array $data, bool $is_new = true): array {
        $errors = [];

        // do field validation
            // if new different validation
            // else

        return $errors;
    }
}