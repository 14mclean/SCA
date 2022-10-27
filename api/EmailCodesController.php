<?php

class EmailCodesController extends Controller{
    public function __construct(EmailCodesGateway $gateway) {
        parent::__construct($gateway, "EmailCode");
    }

    protected function get_validation_errors(array $data, bool $is_new = true): array {
        $errors = [];

        // do field validation
            // if new different validation
            // else

        return $errors;
    }
}