<?php
/**
 * One-off helper for generating a hash from a runtime secret.
 * Set RAPID_RESCUE_SEED_PASSWORD; do not put the password in this file.
 */
$secret = getenv('RAPID_RESCUE_SEED_PASSWORD');
if ($secret === false || $secret === '') {
    fwrite(STDERR, "RAPID_RESCUE_SEED_PASSWORD is not set.\n");
    exit(1);
}

echo password_hash($secret, PASSWORD_DEFAULT), PHP_EOL;
