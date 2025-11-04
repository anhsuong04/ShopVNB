<?php
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'qlshopcaulong');
    $conn = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
    mysqli_set_charset($conn, 'UTF8');
?>