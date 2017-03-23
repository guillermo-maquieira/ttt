<?php

require('../vendor/autoload.php');

class BoardTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://tictactoe.com'
        ]);
    }

    public function testGet_ValidInput_BoardObject()
    {
        $response = $this->client->get('/board', [
            'query' => [
                'id_board' => 1
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id_board', $data);
    }

    public function testPost_NewBoard_BoardObject()
    {
        $boardId = uniqid();

        $response = $this->client->post('/board', [
            'json' => [
                'id_board'    => $boardId
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertEquals($boardId, $data['id_board']);
    }

    public function testDelete_Error()
    {
        $response = $this->client->delete('/board/1', [
            'http_errors' => false
        ]);

        $this->assertEquals(405, $response->getStatusCode());
    }
}