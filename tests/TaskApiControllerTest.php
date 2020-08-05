<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;


/**
 * Class TaskApiControllerTest
 * @package Tests\Unit
 */
class TaskApiControllerTest extends TestCase
{
	public $apiUri = '/api/task/';

	/**
	 * Test POST & Proper Responses
	 * @test
	 */
	public function test_POST_api()
	{
		$client = new Client('http://localhost:8000', [
			'request.options' => [
				'exceptions' => false,
			]
		]);

		$request = $client->post($this->apiUri . 'add', null, json_encode([
			'task' => 'Test Task',
			'date' => '08/28/22'
		]));
		$response = $request->send();

		// Proper Status
		$this->assertEquals(201, $response->getStatusCode());

		// Proper Response
		$this->assertTrue($response->hasHeader('Location'));

		// Proper Data
		$data = json_decode($response->getBody(true), true);

	}

	public function test_DELETE_api() {
		$client = new Client('http://localhost:8000');
		$response = $client->request('DELETE', $this->apiUri)->getStatusCode();
		$response
			->assertStatus(401)
			->assertJson([
				"message" => "Unauthenticated.",
			]);
	}

	public function test_PUT_api() {

	}

	public function test_GET_api() {

	}



}