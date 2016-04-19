<?php

require "vendor/autoload.php";

$config = require "config.php";

$client = new SparkPost\Api\Client(
    new GuzzleHttp\Client(), $config["key"]
);

$reponse = $client->createTransmission([
    "recipients" => [
        [
            "address" => [
                "name" => "Christopher",
                "email" => "cgpitt@gmail.com",
            ],
        ],
    ],
    "subject" => "The email subject",
    "html" => "The email <strong>content</strong>",
]);
