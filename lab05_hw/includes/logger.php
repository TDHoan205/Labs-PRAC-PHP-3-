<?php
// includes/logger.php

function write_log(string $action, string $username): void
{
    $line = date('Y-m-d H:i:s')
        . " | $action | $username\n";

    file_put_contents(
        __DIR__ . '/../data/log.txt',
        $line,
        FILE_APPEND
    );
}
