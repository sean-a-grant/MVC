<?php
include 'c/index.php';
$page = (isset($_GET['__page'])) ? $_GET['__page'] : 'default';
new page($page);
?>