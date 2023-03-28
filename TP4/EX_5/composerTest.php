<?php

require_once('config.php'); 
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class APITests extends PHPUnit\Framework\TestCase
{
    public function testPOST()
    {
        $client = new Client(['base_uri' => _API_URL]);
        $data = array(
            'name' => 'bob',
            'email' => 'bob@leponge.fr'
        );

        $response = $client->request('POST', '/api/programmers', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $data = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('id', $data);
    }
}
?>
