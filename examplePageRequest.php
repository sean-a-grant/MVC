<?php
// Static
include 'c/index.php';
new Page('helloworld');

// If you want to use $_GET (Look into .htaccess for more functionality):
//
// $page = (isset($_GET['__page'])) ? $_GET['__page'] : 'default';
// new page($page);
?>