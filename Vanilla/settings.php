<?php
/*
 * settings.php
 * Put your site settings in this file.
 * If you don't know what to do, consult the documentation
*/

/* DATABASE */
define("_database_hostname", "localhost");
define("_database_username", "root");
define("_database_password", "");
define("_database_database", "");

/* USER SYSTEM */
define("_preferred_hash_method", "sha512");

/* SITEWIDE */
define("_enable_sessions", true);
define("_ROOT", dirname(__FILE__));
define("_SITE_ROOT", "http://" . $_SERVER['SERVER_NAME'] . str_replace(str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']), '', _ROOT));