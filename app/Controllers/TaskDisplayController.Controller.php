<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Model\Tasks;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class Tasks
 * @package App\Controllers
 */
class TaskDisplayController extends BaseController
{
    public function __construct()
    {

    }

    /**
     * @return string
     */
    public static function doTasksList(): string
    {
        $tasks = new Tasks();

        $opt = "<ul class='task-list list-group m-0'>\n";
        foreach ($tasks->getAll() as $task) {
            $opt .= self::taskItemDisplay($task);
        }
        $opt .= "</ul>\n";

        return $opt;
    }

    /**
     * @param $task
     * @return string
     */
    public static function taskItemDisplay($task): string
    {
        $date = strtotime($task['duedate']);
        $jsDate = date("c", ($date + (self::timezone_offset() * 60 * 60)));
        $displayDate = date('M. j', $date);
        return "<li id='task_{$task['id']}' class='task list-group-item mb-0' title='{$task['task']}' data-tid='{$task['id']}' data-date='{$jsDate}'>" .
            "<i class='deleteTask fa fa-window-close-o pr-2 task-action' data-toggle='tooltip' data-placement='top' title='Delete'></i>" .  // Delete Icon
            "<i class='editTask fa fa-pencil-square-o pr-2 task-action' data-toggle='tooltip' data-placement='top' title='Edit'></i>" .     // Edit Icon
            "{$task['task']} " .                                                                                                        // Title
            "<span class='duedate float-right'>{$displayDate}</span>" .                                                                     // Date
            "</li>\n";
    }

    /**
     * Returns the offset from the origin timezone to the remote timezone, in seconds.
     * @return int;
     */
    public static function timezone_offset()
    {
        $remote_tz = 'America/Los_Angeles';
        $origin_tz = 'America/New_York';
        if (($origin_tz === null) && !is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime("now", $origin_dtz);
        $remote_dt = new DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
        return $offset / 2400;
    }
}
