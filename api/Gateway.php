<?php

interface Gateway {
    public function __construct(Database $db);
    public function get_all(): array;
    public function create(array $data): string;
    public function get(string $id): array | false;
    public function update(array $current_expert_details, array $new_expert_details): int;
    public function delete(string $id): int;
}