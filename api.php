<?php

use App\Controllers\Api;

require_once (__DIR__ . '/app/Bootstrap.php');
/**
 * This is a Simple RESTApi - No Authentication
 * No Harm In That Right...
 */
// Api Headers
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$Api = new Api();
$Api->processTaskRequest();