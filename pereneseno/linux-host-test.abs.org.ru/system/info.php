<?php
include_once 'config.php';

db::init();
$sql = "SELECT * FROM `user`";
$users = db::init()->getAll($sql);

echo '<pre>';
echo getenv('DBUSER');
echo getenv('DBPASS');
print_r($users);
echo '</pre>';
