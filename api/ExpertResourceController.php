<?php

class ExpertResourceController extends Controller{
    public function __construct(ExpertResourceGateway $gateway) {
        parent::__construct($gateway, "Resource");
    }

    protected function get_validation_errors(array $data, bool $is_new = true): array {
        $errors = [];

        // do field validation
            // if new different validation
            // else

        return $errors;
    }
}