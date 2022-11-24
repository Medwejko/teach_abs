<?php

echo '<pre>';
print_r($_SERVER);
$debug_user = getenv('DBUSER');
$debug_pass = getenv('DBPASS');

print_r($debug_user);
print_r($debug_pass);

echo '</pre>';

?>