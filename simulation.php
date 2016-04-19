<?php

require "vendor/autoload.php";

$config = require "config.php";

$client = new GuzzleHttp\Client();

$url = "https://api.sparkpost.com/api/v1/transmissions";

$response = $client->request("POST", $url, [
    "headers" => [
        "Content-type" => "application/json",
        "Authorization" => $config["key"],
    ],
    "body" => json_encode([
        "recipients" => [
            [
                "address" => [
                    "name" => "Chris",
                    "email" => "cgpitt@gmail.com",
                ],
            ],
        ],
        "content" => [
            "from" => "sandbox@sparkpostbox.com",
            "subject" => "Start your SparkPost adventure today!",
            "html" => "...With a new client.",
        ],
    ]),
]);
