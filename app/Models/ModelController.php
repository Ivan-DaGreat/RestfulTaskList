<?php

abstract class ModelController {
    /**
     * Get A Single Task By Id
     * @param Int $id Task Id
     * @return array|bool
     */
    abstract public function get($id): array;

    /**
     * Update a Task
     * @param Int $taskId Task Id
     * @return bool
     */
    abstract public function update($taskId): bool;

    /**
     * Insert a new Task
     * @param string $taskName
     * @param string $taskDate
     * @return bool
     */
    abstract public function insert(string $taskName, string $taskDate): bool;

    /**
     * Delete a Task
     * @param Int $id Task Id
     * @return bool
     */
    abstract public function delete($id): bool;
}