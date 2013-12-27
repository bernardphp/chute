<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Chute\\Tests', __DIR__);

if (!class_exists('Redis')) {
    // This will make sure we do not require the Redis class to be present, but require that
    // we have a class with a similiar API.
    require_once __DIR__ . '/Chute/Tests/Fixtures/Redis.php';
}
