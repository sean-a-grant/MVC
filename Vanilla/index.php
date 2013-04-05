<?php
// Define the root of our project
define("_ROOT", dirname(__FILE__));
// Define the site root of our project (the WWW accessible layer)
define("_SITE_ROOT", $_SERVER['SERVER_NAME']);

// Debug
error_reporting(E_ALL);

// Our general classes
require "classes/Loader.class.php";
require "classes/BaseController.class.php";
require "classes/BaseModel.class.php";

// Create the page
new Loader($_GET, $_POST);