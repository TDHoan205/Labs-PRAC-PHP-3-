<?php
// includes/remember.php

function generate_token(): string {
    return bin2hex(random_bytes(32));
}

function load_tokens(): array {
    $file = __DIR__ . '/../data/tokens.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function save_tokens(array $tokens): void {
    file_put_contents(
        __DIR__ . '/../data/tokens.json',
        json_encode($tokens, JSON_PRETTY_PRINT)
    );
}
