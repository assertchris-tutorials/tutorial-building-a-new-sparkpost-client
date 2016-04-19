<?php

namespace SparkPost\Api\Test;

use Mockery;
use Mockery\MockInterface;
use SparkPost\Api\Client;
use GuzzleHttp\Client as GuzzleClient;

class ClientTest extends AbstractTest
{
    /**
     * @test
     */
    public function itCreatesTransmissions()
    {
        /** @var MockInterface|GuzzleClient $mock */
        $mock = Mockery::mock(GuzzleClient::class);

        $sendThroughGuzzle = [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "[your SparkPost API key here]",
            ],
            "body" => json_encode([
                "recipients" => [
                    [
                        "address" => [
                            "name" => "Christopher",
                            "email" => "cgpitt@gmail.com",
                        ],
                    ],
                ],
                "content" => [
                    "from" => "sandbox@sparkpostbox.com",
                    "subject" => "The email subject",
                    "html" => "The email <strong>content</strong>",
                ],
            ]),
        ];

        $mock
            ->shouldReceive("request")
            ->with(
                Mockery::type("string"),
                Mockery::type("string"),
                $sendThroughGuzzle
            )
            ->andReturn($mock);

        $mock
            ->shouldReceive("getBody")
            ->andReturn(
                json_encode(["foo" => "bar"])
            );

        $client = new Client(
            $mock, "[your SparkPost API key here]"
        );

        $this->assertEquals(
            ["foo" => "bar"],
            $client->createTransmission([
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
            ])
        );
    }
}
