<?php
// Define the root of our project
define("_ROOT", dirname(__FILE__));

// Our general classes
require "classes/Loader.class.php";
require "classes/BaseController.class.php";
require "classes/BaseModel.class.php";

// create the controller and execute action
$loader = new Loader($_GET);
$controller = $loader->createController();
$controller->executeAction();