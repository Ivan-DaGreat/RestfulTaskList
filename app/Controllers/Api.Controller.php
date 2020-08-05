<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Model\Tasks;
use App\Controllers\Routes;


/**
 * Class Api
 * @package App\Controllers
 */
class Api extends BaseController
{
    public $taskInstance;
    public $postData;
    public $response;
    public $errorResponse;
    public $taskId;

    public function __construct()
    {
        $this->taskInstance = new Tasks();
        $this->response = null;
        $this->errorResponse = null;
        $this->taskId = Routes::getTaskId();
    }

	/**
	 * Small router for the Tasks
	 */
    public function processTaskRequest():void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // REST Actions
        switch ($httpMethod) {
            case 'GET':

                break;

            case 'PUT':
                $this->updateTask();
                break;

            case 'POST':
                $this->insertTask($_POST);
                break;

            case 'DELETE':
                $this->deleteTask();
                break;
        }

        // Render response
        header($this->response['header_code']);
        if ($this->response['status'] === 'success' || !$this->errorResponse) {
            print json_encode($this->response);
            return;
        }

        print json_encode($this->errorResponse);
    }

    /**
     * Update Task
     */
    public function updateTask(): void
    {
        if ($resp = $this->taskInstance->update($this->taskId)) {
            $this->setSuccessResponseHeaders('Task Updated', 'HTTP/1.1 200 resource updated successfully', $this->taskInstance->getAll());
            return;
        }

        $this->setErrorResponseHeaders();
    }

    /**
     * @param string $message
     * @param string $header
     * @param array $tasks
     * @return void
     */
    public function setSuccessResponseHeaders($message = '', $header = 'HTTP/1.1 200 OK', $tasks = []): void
    {
        $this->response['header_code'] = $header;
        $this->response['status'] = 'success';
        $this->response['message'] = $message;
        $this->response['tasks'] = $tasks;
    }

    /**
     * @param string $message
     * @param string $header
     * @return void
     */
    public function setErrorResponseHeaders($message = 'Task Not Found', $header = 'HTTP/1.1 404 Not Found'): void
    {
        $this->errorResponse = ['error' => $message];
        $this->response['header_code'] = $header;
        $this->response['status'] = 'error';
    }

    /**
     * Add Task
     * @param $postData
     */
    public function insertTask($postData): void
    {
        if (isset($postData['task'], $postData['date']) && $resp = $this->taskInstance->insert($postData['task'], $postData['date'])) {
            $this->setSuccessResponseHeaders('Task Created', 'HTTP/1.1 201 Created', $this->taskInstance->getAll());
            return;
        }

        $this->setErrorResponseHeaders('Invalid input', 'HTTP/1.1 422 Unprocessable Entity');
    }

    /**
     * Delete Task
     */
    public function deleteTask(): void
    {
        if ($resp = $this->taskInstance->delete($this->taskId)) {
            $this->setSuccessResponseHeaders();
            return;
        }

        $this->setErrorResponseHeaders();
    }

    /**
     * @param $id
     */
    public function getTask($id)
    {

    }


}