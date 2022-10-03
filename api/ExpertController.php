<?php

class ExpertController extends Controller{
    public function __construct(ResourceGateway $gateway) {
        parent::__construct($gateway, "Expert");
    }

    protected function get_validation_errors(array $data, bool $is_new = true): array {
        $errors = [];

        // do field validation
            // if new different validation
            // else

        return $errors;
    }
}