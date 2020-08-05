<?php
namespace App\Controllers;

/**
 * Class Tasks
 * @package App\Controllers
 */
class Routes
{
    /**
     * Get Current Route
     * @return array
     */
    public static function getRoute() {
        return explode('/', $_SERVER['REQUEST_URI']);
    }

    /**
     * Get TaskId
     * @return int
     */
    public static function getTaskId(): int {
        return (int) self::getRoute()[3];
    }
}
