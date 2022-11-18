<?php

class ExpertiseController extends Controller{
    public function __construct(ExpertiseGateway $gateway) {
        parent::__construct($gateway, "Expertise");
    }

    protected function get_validation_errors(array $data, bool $is_new = true): array {
        $errors = [];

        // do field validation
            // if new different validation
            // else

        return $errors;
    }
}