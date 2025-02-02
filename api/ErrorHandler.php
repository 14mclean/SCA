<?php

class ErrorHandler {
    public static function handle_exception(Throwable $exception): void {
        http_response_code(500);
        
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
        ]);
    }

    public static function handle_error(int $errno, string $errstring, string $errfile, int $errline): bool {
        throw new ErrorException($errstring, 0, $errno, $errfile, $errline);
    }
}