<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
try {
    $dotenv->safeLoad();
} catch (Exception $exception) {
    die($exception);
}