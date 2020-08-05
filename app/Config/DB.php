<?php
namespace App\Config;

use http\Exception;
use mysqli;

/**
 * Class DB
 */
class DB
{
    private const USER = 'task_admin';
    private const PASS = 'letmein';
    private const DB = 'task_list';

    public $connection;

    /**
     * Creates a DB Connection
     */
    public function connect(): mysqli
    {
        try {
            return $this->connection = mysqli_connect("localhost", self::USER, self::PASS, self::DB);
        } catch (Exception $exception) {
            print  $exception;
        }
    }

}
