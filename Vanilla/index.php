<?php
// Debug
require("classes/php_error.php");
\php_error\reportErrors();

// Our general classes
require "settings.php";
require "classes/Loader.class.php";
require "classes/BaseController.class.php";
require "classes/BaseModel.class.php";

// Create the page
new Loader($_GET, $_POST);