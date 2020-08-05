<?php
/**
 * The Controllers we will use
 * ...maybe I should have used an autoloader.
 */
include __DIR__ . '/Config/DB.php';
include __DIR__ . '/Models/ModelController.php';
include __DIR__ . '/Models/Model.php';
include __DIR__ . '/Models/Tasks.php';
include __DIR__ . '/Controllers/BaseController.Controller.php';
include __DIR__ . '/Controllers/TaskDisplayController.Controller.php';

/**
 * I'll go ahead some routing in here */
include __DIR__ . '/Controllers/Routes.Controller.php';
include __DIR__ . '/Controllers/Api.Controller.php';


