<?php

namespace SparkPost\Api;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var string
     */
    private $base = "https://api.sparkpost.com/api/v1";

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var string
     */
    private $key;

    /**
     * @param GuzzleClient $client
     * @param string $key
     */
    public function __construct(GuzzleClient $client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function createTransmission(array $options = [])
    {
        $options = array_replace_recursive([
            "from" => "sandbox@sparkpostbox.com",
        ], $options);

        $send = [
            "recipients" => $options["recipients"],
            "content" => [
                "from" => $options["from"],
                "subject" => $options["subject"],
                "html" => $options["html"],
            ]
        ];

        return $this->request("POST", "transmissions", $send);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     *
     * @return array
     */
    private function request($method, $endpoint, array $options = [])
    {
        $endpoint = $this->base . "/" . $endpoint;

        $response = $this->client->request($method, $endpoint, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => $this->key,
            ],
            "body" => json_encode($options),
        ]);

        return json_decode($response->getBody(), true);
    }
}
