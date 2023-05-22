<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BreweryTest extends TestCase
{
    /**
     * Test the /breweries endpoint.
     *
     * @return void
     */
    public function testFetchBreweries()
    {
        // Mock the external API response
        $this->mockHttp([
            'breweries' => [
                [
                    "id" => "5128df48-79fc-4f0f-8b52-d06be54d0cec",
										"name" => "(405) Brewing Co",
										"address" => [
												"street" => "1716 Topeka St",
												"city" => "Norman",
												"state" => "Oklahoma",
												"postal_code" => "73069-8224"
								],
                ],
            ],
        ]);

        // Make a GET request to the /breweries endpoint
        $response = $this->get('/breweries');

        // Assert the response status code
        $response->assertStatus(200);

        // Assert the response structure and data
        $response->assertJson([
            [
                "id" => "5128df48-79fc-4f0f-8b52-d06be54d0cec",
                "name" => "(405) Brewing Co",
                "address" => [
										"street" => "1716 Topeka St",
										"city" => "Norman",
										"state" => "Oklahoma",
										"postal_code" => "73069-8224"
								],
            ],
        ]);
    }

    /**
     * Mock the HTTP request to the external API.
     *
     * @param  array  $data
     * @return void
     */
    private function mockHttp(array $data)
    {
        $mockedResponse = json_encode($data);

        $this->mock(\GuzzleHttp\Client::class, function ($mock) use ($mockedResponse) {
            $mock->shouldReceive('get->getBody->getContents')
                ->andReturn($mockedResponse);
        });
    }
}
